import {ref} from "vue";
import {useLayout} from "src/composables/layout.js";

const _Property = __Properties__
const _VCard = VCardProperty

const Properties = ref({})

_Property.map(function(_property){
  let id = _property.v_card_property_id, vCard = _VCard.find(Pro => Pro.id === id);
  let { category,parameters,property:item,value_type } = vCard
  let params = parameters.reduce((obj,key) => Object.assign(obj,{ [key]:undefined }),{})
  let { name,value,params:_params } = _property
  params = Object.assign(params,_params)
  Properties.value[name] = { name,category,item,value_type,value,params }
})

function keyVal(array,key,val){
  let returnObj = new Object({})
  array.map(ary => returnObj[ary[key]] = ary[val] );
  return returnObj;
}

export function useProperty(){

  function propertyValue(companyProps,individualProps){
    const lProps = useLayout().index.value, lPropsKeys = Object.keys(lProps), propValue = new Object({})
    const cProps = keyVal(companyProps,'name','value'), iProps = keyVal(individualProps,'name','value')
    for (const lPropKey of lPropsKeys) {
      if(iProps.hasOwnProperty(lPropKey)) propValue[lPropKey] = iProps[lPropKey];
      else if(cProps.hasOwnProperty(lPropKey)) propValue[lPropKey] = cProps[lPropKey];
      else companyProps[lPropKey] = lProps[lPropKey].property.value
    }
    return propValue;
  }
  return { Properties,propertyValue }
}
