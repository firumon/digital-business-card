import {useLayout} from "src/composables/layout.js";
import {computed} from "vue";
import {useCompany} from "src/composables/company.js";

const _Individual = __Individual__

export function useIndividual(){
  const { name,properties:iProps } = _Individual
  const { index,properties_vcard } = useLayout()
  const properties = computed(() => iProps.map(({ property_name,value }) => Object.assign({},index.value[property_name] ?. property || {},{ value })))
  const full_name = computed(() => (properties_vcard.value.find(vProp => vProp.item === 'FN') || { name }).name)
  const company_name = computed(() => (properties_vcard.value.find(vProp => vProp.item === 'ORG') || { name: useCompany().company_name.value }).name)
  return { name,properties,full_name,company_name }
}
