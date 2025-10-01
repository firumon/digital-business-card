import {useLayout} from "src/composables/layout.js";
import {computed} from "vue";

const _Company = __Company__

export function useCompany(){
  const { name,logo_url:logo,logo_width:width,logo_height:height,base_url:url,properties:cProps,brand_primary,brand_secondary,color_primary,color_secondary } = _Company
  const { index,properties_vcard } = useLayout()
  const properties = computed(() => cProps.map(({ property_name,value }) => Object.assign({},index.value[property_name] ?. property || {},{ value })))
  const company_name = computed(() => (properties_vcard.value.find(vProp => vProp.item === 'ORG') || { name }).name)
  return { name,logo,width,height,url,properties,company_name,brand_primary,brand_secondary,color_primary,color_secondary }
}
