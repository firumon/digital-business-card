import { defineStore, acceptHMRUpdate } from 'pinia'
import {computed, ref} from "vue";
import {api} from "boot/axios.js";
import {find, keyBy, map, mapKeys, mapValues} from "lodash";
import {useUserStore} from "stores/user.js";

export const useCompanyStore = defineStore('company', () => {
  const _Companies = ref(null)
  const Companies = computed(() => _Companies.value || fetchCompanies() || [])
  const CompaniesById = computed(() => keyBy(Companies.value,'id'))

  const CompanySelectOptions = computed(() => map(Companies.value,C => ({ label:C.name,value:C.id })))

  function fetchCompanies(){ api('company').then(_props => _Companies.value = _props) }
  function addNewCompany(data){ return new Promise(resolve => api('company/save',data).then(_props => _Companies.value = _props).then(resolve)) }
  function updateCompany(id,data){ return new Promise(resolve => api('company/update', { id,...data }).then(_props => _Companies.value = _props).then(resolve)) }

  const Individuals = computed(() => (company_id) => CompaniesById.value ?. [company_id] ?. individuals || [])
  function addIndividual(company_id,individual_name){ return new Promise(resolve => api('company/individual', { company_id,individual_name }).then(_props => _Companies.value = _props).then(resolve)) }

  const Properties = computed(() => (company_id) => zippedObj((CompaniesById.value ?. [company_id] ?. properties || []),'property_name','value'))
  function syncCompanyProperties(id,data){ return new Promise(resolve => api('company/properties', { company_id:id,...data }).then(_props => _Companies.value = _props).then(resolve)) }

  const Individual = computed(() => (company_id,individual_id) => find(Individuals.value(company_id),['id',parseInt(individual_id)]))
  const IndividualProperties = computed(() => (company_id,individual_id) => zippedObj((Individual.value(company_id,individual_id) ?. properties || []),'property_name','value'))
  function updateIndividualName(company_id,individual_id,name){ return new Promise(resolve => api('company/individual_name', { company_id,individual_id,name }).then(_props => _Companies.value = _props).then(resolve)) }
  function updateIndividualProperties(company_id,individual_id,properties){ return new Promise(resolve => api('company/individual_properties', { company_id,individual_id,...properties }).then(_props => _Companies.value = _props).then(resolve)) }

  const Users = computed(() => (company_id) => CompaniesById.value ?. [company_id] ?. users || [])
  function createAndAddUser(company_id,user_details){ return new Promise(resolve => api('company/user', { company_id,user:user_details }).then(_props => useUserStore().fetchUsers() || _props).then(_props => _Companies.value = _props).then(resolve)) }

  function createAndAddIndividualUser(company_id,individual_id,user_details){ return new Promise(resolve => api('company/individual_user', { company_id,individual_id,user:user_details }).then(_props => useUserStore().fetchUsers() || _props).then(_props => _Companies.value = _props).then(resolve)) }
  function syncCompanyUsers(company_id,user_ids){ return new Promise(resolve => api('company/users_sync', { company_id,user_ids }).then(_props => _Companies.value = _props).then(resolve)) }

  function addIndividualUser(company_id,individual_id,user_id){ return new Promise(resolve => api('company/individual_user_add', { company_id,user_id,individual_id }).then(_props => _Companies.value = _props).then(resolve)) }
  function removeIndividualUser(company_id,individual_id,user_id){ return new Promise(resolve => api('company/individual_user_remove', { company_id,user_id,individual_id }).then(_props => _Companies.value = _props).then(resolve)) }

  return { Companies,CompaniesById,addNewCompany,updateCompany,Individuals,addIndividual,CompanySelectOptions,Properties,syncCompanyProperties,Individual,updateIndividualName,IndividualProperties,updateIndividualProperties,Users,createAndAddUser,createAndAddIndividualUser,syncCompanyUsers,addIndividualUser,removeIndividualUser }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useCompanyStore, import.meta.hot))
}

function zippedObj(objArray,keyBy,valueBy){ return mapValues(mapKeys(objArray,keyBy),valueBy) }
