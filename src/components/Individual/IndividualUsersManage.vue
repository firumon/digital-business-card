<template>
  <q-card>
    <q-bar><q-icon name="lens_blur" /><q-space /><q-btn icon="close" v-close-popup flat color="primary" dense round /></q-bar>
    <q-card-section class="text-bold bg-grey-2">User Logins</q-card-section>
    <q-list>
      <q-item v-for="User in IndividualUsers" v-if="IndividualUsers.length" clickable v-ripple @click="updateUser = User">
        <q-item-section side><q-icon name="lens_blur" color="green" /></q-item-section>
        <q-item-section>
          <q-item-label>{{ User.name }}</q-item-label>
          <q-item-label caption>{{ User.email }}</q-item-label>
        </q-item-section>
      </q-item>
      <q-item-label v-else header>No users</q-item-label>
    </q-list>
    <q-card-section class="text-bold bg-grey-2">Add User</q-card-section>
    <q-card-section class="q-gutter-y-xs">
      <q-input v-model="newUser.name" label="Name" outlined />
      <div class="row q-col-gutter-x-xs">
        <div class="col"><q-input v-model="newUser.email" label="Email" outlined /></div>
        <div class="col"><q-input v-model="newUser.password" label="Password" outlined /></div>
      </div>
      <q-btn color="primary" padding="sm lg" label="Add User" @click="addUser" />
    </q-card-section>
    <q-dialog persistent full-width :model-value="updateUser !== null"><IndividualUserUpdate :user="updateUser" @close="updateUser = null" /></q-dialog>
    <InnerLoading :loading="loading" />
  </q-card>
</template>

<script setup>
import {computed, reactive, ref} from "vue";
import InnerLoading from "components/InnerLoading.vue";
import {useCompanyStore} from "stores/company.js";
import {map} from "lodash";
import {useUserStore} from "stores/user.js";
import IndividualUserUpdate from "components/Individual/IndividualUserUpdate.vue";

const companyStore = useCompanyStore(), userStore = useUserStore()
const props = defineProps(['company_id','individual_id'])

const loading = ref(false)

const newUser = reactive({ name:'',email:'',password:'' }), updateUser = ref(null)
const Individual = computed(() => companyStore.Individual(props.company_id,props.individual_id))
const IndividualUsers = computed(() => Individual.value ? map(Individual.value.users,user_id => userStore.UsersById[user_id]).filter(u => u) : [])

function addUser(){
  if(!newUser.name || !newUser.email || !newUser.password) return null; loading.value = true;
  companyStore.createAndAddIndividualUser(props.company_id,props.individual_id,newUser).then(added)
}
function added(){
  map(newUser,(v,k) => newUser[k] = '');
  loading.value = false;
}
</script>
