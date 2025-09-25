<template>
  <q-page padding class="q-gutter-y-xs">
    <ChooseCompanySelect label="Select Company" v-model="selected" v-if="!props.company_id" />
    <q-card>
      <q-card-section class="text-bold bg-grey-2 flex items-center">Managers <q-space /> <q-btn round color="secondary" dense icon="add" @click="create = true" :disable="!companyId" /> </q-card-section>
      <q-list>
        <q-item v-for="Manager in Managers">
          <q-item-section side><q-checkbox :val="Manager.id" v-model="selectedManagers" /></q-item-section>
          <q-item-section>
            <q-item-label>{{ Manager.name }}</q-item-label>
            <q-item-label caption>{{ Manager.email }}</q-item-label>
          </q-item-section>
          <q-item-section side>{{ (UserCompanyNames[Manager.id] || []).join(', ') }}</q-item-section>
        </q-item>
      </q-list>
      <q-card-actions class="bg-grey-2" align="right">
        <q-btn color="primary" label="Sync Managers" @click="syncManagers" :disable="!Company" />
      </q-card-actions>
    </q-card>
    <q-dialog v-model="create" persistent>
      <q-card class="full-width">
        <q-bar><q-icon name="groups_3" /><q-space /><q-btn dense flat icon="close" v-close-popup /></q-bar>
        <q-card-section class="q-gutter-y-xs">
          <q-input v-model="newUser.name" label="Name" outlined />
          <q-input v-model="newUser.email" label="Email" outlined />
          <q-input v-model="newUser.password" label="Password" outlined />
        </q-card-section>
        <q-card-actions align="right" class="bg-grey-2">
          <q-btn color="primary" label="Add User" @click="createAndAddUser" />
        </q-card-actions>
        <InnerLoading :loading="loading" />
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script setup>
import InnerLoading from "components/InnerLoading.vue";
import ChooseCompanySelect from "components/Company/ChooseCompanySelect.vue";
import {computed, reactive, ref, watch} from "vue";
import {useCompanyStore} from "stores/company.js";
import {filter, map} from "lodash";
import {useUserStore} from "stores/user.js";
import {useTitle} from "src/composables/title.js";

const companyStore = useCompanyStore(), userStore = useUserStore()
const props = defineProps(['company_id'])

const selected = ref(props.company_id)
const loading = ref(false)
const create = ref(false)
const newUser = reactive({name:'',email:'',password:''})

const selectedManagers = ref([])

const companyId = computed(() => selected.value || props.company_id)
const Company = computed(() => companyId.value ? companyStore.CompaniesById[companyId.value] : null)
const Managers = computed(() => filter(userStore.Users,['role','Manager']))
const UserCompanyNames = computed(function(){
  const data = ({}); if(!Managers.value) return data;
  map(companyStore.Companies,company => map(company.users,user_id => {
    if(!data.hasOwnProperty(user_id)) data[user_id] = [];
    if(!data[user_id].includes(company.name)) data[user_id].push(company.name)
  }))
  return data;
})

watch(Company,function(Company){
  selectedManagers.value = Company ? companyStore.Users(Company.id) : []
},{ immediate:true,deep:true })

function syncManagers(){
  loading.value = true;
  companyStore.syncCompanyUsers(companyId.value,selectedManagers.value).then(done)
}

function createAndAddUser(){
  if(!newUser.name || !newUser.email || !newUser.password) return null; loading.value = true;
  companyStore.createAndAddUser(companyId.value,newUser).then(done)
}
function done(){
  map(newUser,(val,key) => newUser[key] = '');
  create.value = false; loading.value = false;
}
useTitle(Company)
</script>
