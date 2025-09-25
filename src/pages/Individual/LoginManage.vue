<template>
  <q-page padding>
    <q-card>
      <q-card-section class="bg-grey-2 text-bold">Existing Individuals</q-card-section>
      <q-list>
        <template v-for="(company,cId) in companyIndNames">
          <q-item><q-item-section><q-item-label class="text-bold">{{ company.company_name }}</q-item-label></q-item-section></q-item>
          <q-item v-for="(iId,idx) in company.individuals">
            <q-item-section>{{ idx+1 }}. {{ userIdNames[iId] }}</q-item-section>
            <q-item-section side><q-btn dense padding="xs md" label="Remove" outline rounded color="primary" @click="remove(cId,iId)" /></q-item-section>
          </q-item>
          <q-separator />
        </template>
      </q-list>
      <q-card-section class="bg-grey-2 text-bold">Companies</q-card-section>
      <q-card-section>
        <q-chip :label="Company.name" @click="selectedCompany = Company.id" @remove="selectedCompany = null" clickable :outline="selectedCompany !== Company.id" v-for="Company in companies" color="secondary" text-color="white" />
      </q-card-section>
      <q-card-section class="bg-grey-2 text-bold">Company Individuals</q-card-section>
      <q-list v-if="selectedCompanyIndividuals.length" separator>
        <q-item v-for="individual in selectedCompanyIndividuals">
          <q-item-section>
            <q-item-label caption>{{ individual.code }}</q-item-label>
            <q-item-label>{{ individual.name }}</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-btn dense padding="xs md" label="Remove" outline rounded color="primary" v-if="companyIndNames[individual.company_id] && companyIndNames[individual.company_id].individuals.includes(individual.id)" @click="remove(individual.company_id,individual.id)" />
            <q-btn dense padding="xs md" label="Add" outline rounded color="primary" v-else @click="add(individual.company_id,individual.id)" />
          </q-item-section>
        </q-item>
      </q-list>
    </q-card>
    <InnerLoading :loading="loading" />
  </q-page>
</template>

<script setup>
import {computed, ref, watch} from "vue";
import {useUserStore} from "stores/user.js";
import {useTitle} from "src/composables/title.js";
import {filter, flatMap, map} from "lodash";
import {useCompanyStore} from "stores/company.js";
import InnerLoading from "components/InnerLoading.vue";

const userStore = useUserStore(), companyStore = useCompanyStore()
const props = defineProps(['user_id'])

const loading = ref(false)
const companyIndNames = ref({})
const selectedCompany = ref(null)
const userIdNames = ref({})

const User = computed(() => userStore.UsersById[props.user_id])
useTitle(User)

const companies = computed(() => companyStore.Companies)
const individualsWithUserLogin = computed(() => User.value ? filter(flatMap(companyStore.Companies,'individuals'),({ users }) => users.includes(User.value.id)) : [])
const selectedCompanyIndividuals = computed(() => selectedCompany.value ? companyStore.CompaniesById[selectedCompany.value].individuals : [])

function getIndividualCompanyName(company_id){ return companyStore.CompaniesById[company_id].name }
watch(individualsWithUserLogin,function(iwul){
  companyIndNames.value = {}
  map(iwul,function({ company_id,id,name }){
    if(!companyIndNames.value.hasOwnProperty(company_id)) companyIndNames.value[company_id] = { company_name:getIndividualCompanyName(company_id),individuals:[] };
    companyIndNames.value[company_id].individuals.push(id)
    userIdNames.value[id] = name
  })
},{ immediate:true })

function remove(company_id,individual_id){
  loading.value = true;
  companyStore.removeIndividualUser(company_id,individual_id,User.value.id).then(() => loading.value = false)
}
function add(company_id,individual_id){
  loading.value = true;
  companyStore.addIndividualUser(company_id,individual_id,User.value.id).then(() => loading.value = false)
}
</script>
