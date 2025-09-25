import { defineStore, acceptHMRUpdate } from 'pinia'
import {computed, ref} from "vue";
import {groupBy, keyBy} from "lodash";
import {api} from "boot/axios.js";

export const usePropertyStore = defineStore('property', () => {
  const VCardProperties = ref(VCardProperty)
  const VCardPropertiesById = computed(() => keyBy(VCardProperties.value,'id'))
  const _Properties = ref(null)

  const Properties = computed(() => _Properties.value ? _Properties.value : fetchProperties())
  const PropertiesByVCardPropertyId = computed(() => Properties.value ? groupBy(Properties.value,'v_card_property_id') : {})
  const PropertiesByPropertyName = computed(() => Properties.value ? keyBy(Properties.value,'name') : {})
  function fetchProperties(){ api('property').then(_props => _Properties.value = _props) }
  function addNewProperty(data){ return new Promise(resolve => api('property/save',data).then(_props => _Properties.value = _props).then(resolve)) }
  function deleteProperty(id){ return new Promise(resolve => api('property/delete', { id }).then(_props => _Properties.value = _props).then(resolve)) }

  const vCardParamsOfPropertyName = computed(() => (propertyName) => VCardPropertiesById.value[PropertiesByPropertyName.value[propertyName]?.v_card_property_id]?.parameters || [])

  return { VCardProperties,VCardPropertiesById,PropertiesByVCardPropertyId,PropertiesByPropertyName,Properties,addNewProperty,deleteProperty,vCardParamsOfPropertyName }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(usePropertyStore, import.meta.hot))
}
