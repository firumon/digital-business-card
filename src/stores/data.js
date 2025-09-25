import { defineStore, acceptHMRUpdate } from 'pinia'
import {omit} from "lodash";
import {computed,ref} from "vue";

const individualPropertiesExceptParams = ['code','name','designation']
const layoutPropertiesExceptParams = ['actions','mandatory','contacts','individual']

export const useDataStore = defineStore('data', () => {
  const company = ref(__DATA.company), individual = ref(__DATA.individual);
  const actions = ref(__DATA.layout.actions)
  const params = computed(() => ({ company:company.value.params,individual:omit(individual.value,individualPropertiesExceptParams),layout:omit(__DATA.layout,layoutPropertiesExceptParams) }))
  const layout = computed(() => ({
    contacts: __DATA.layout.contacts,
    mandatory: __DATA.layout.mandatory,
    individual: __DATA.layout.individual,
    params: params.value.layout
  }))
  return { company,individual,actions,params,layout }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useDataStore, import.meta.hot))
}
