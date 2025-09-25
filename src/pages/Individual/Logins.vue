<template>
  <q-page padding>
    <q-card>
      <q-card-section class="bg-grey-2 text-bold flex no-wrap items-center">Individual Login Users <q-space /> <q-input dense outlined label="Filter" v-model="filterText" /></q-card-section>
      <q-list separator>
        <q-item v-for="User in individualLoginUsers">
          <q-item-section top>
            <q-item-label>{{ User.name }}</q-item-label>
            <q-item-label caption>{{ User.email }}</q-item-label>
          </q-item-section>
          <q-item-section v-if="userIndividuals[User.id]">
            <template v-for="(company) in userIndividuals[User.id]">
              <q-item-label caption>{{ company.company_name }}</q-item-label>
              <q-item-label v-for="name in company.individuals">{{ name }}</q-item-label>
            </template>
          </q-item-section>
          <q-item-section side top>
            <q-btn dense round icon="forward" flat color="primary" @click="routes.push('individual_login_manage',User)" />
          </q-item-section>
        </q-item>
      </q-list>
    </q-card>
  </q-page>
</template>

<script setup>
import {computed, ref, watch} from "vue";
import {useUserStore} from "stores/user.js";
import {filter, flatMap, map} from "lodash";
import {useCompanyStore} from "stores/company.js";
import {useRoutes} from "src/composables/routes.js";

const userStore = useUserStore(), companyStore = useCompanyStore(), routes = useRoutes()

const filterText = ref('')
const userIndividuals = ref({})

const individualLoginUsers = computed(() => filter(filter(userStore.Users,['role','Individual']),(user) => filterText.value ? [user.name,user.email].join(" ").toLowerCase().includes(filterText.value.toLowerCase()) : true))
const individualsWithLogin = computed(() => filter(flatMap(companyStore.Companies,'individuals'),({ users }) => users.length))

watch(individualsWithLogin,function(iwl){
  userIndividuals.value = {}
  map(iwl,({ company_id,users,name }) => map(users,function(user_id){
    if(!userIndividuals.value.hasOwnProperty(user_id)) userIndividuals.value[user_id] = {};
    if(!userIndividuals.value[user_id].hasOwnProperty(company_id)) userIndividuals.value[user_id][company_id] = { company_name:getIndividualCompanyName(company_id),individuals:[] }
    userIndividuals.value[user_id][company_id].individuals.push(name)
  }))
},{ immediate:true })

function getIndividualCompanyName(company_id){ return companyStore.CompaniesById[company_id].name }
</script>
