import {useProperty} from "src/composables/property.js";
import {computed, ref} from "vue";

const _Layout = __Layout__

const globalProperties = computed(() => useProperty().Properties.value)
const propertyToInitObj = ({ property_name,params }) => Object.assign({},globalProperties.value[property_name],{ params:{ ...globalProperties.value[property_name] ?. params || {},...params } })
const properProperty = (pObj) => ['name','value','image'].reduce((obj,key) => Object.assign(obj,{ [key]:pObj[key] }),{})
const properPropertyVCard = (pObj) => ['name','value','image'].reduce((obj,key) => Object.assign(obj,{ [key]:pObj[key] }),propertyToInitObj(pObj))

const properties_vcard = computed(() => _Layout.properties.filter(prop => prop.type === 'vcard').map(properPropertyVCard))
const properties_layout = computed(() => _Layout.properties.filter(prop => prop.type === 'layout').map(properProperty))
const index = ref({})

_Layout.properties.map(function({ type,name }){
  let idx = (type === 'vcard' ? properties_vcard.value : properties_layout.value).findIndex(prop => prop.name === name),
    property = (type === 'vcard' ? properties_vcard.value : properties_layout.value)[idx];
  index.value[name] = { type,idx,property }
})

export function useLayout(){
  const { name,brand_primary,brand_secondary,color_primary,color_secondary } = _Layout
  return { name,brand_primary,brand_secondary,color_primary,color_secondary,properties_vcard,properties_layout,index }
}
