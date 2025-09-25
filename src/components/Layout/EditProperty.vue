<template>
  <q-card>
    <q-card-section class="text-bold bg-grey-2 flex items-center">Edit Property <q-space /><q-btn icon="close" color="negative" v-close-popup flat dense /></q-card-section>
    <q-card-section class="q-gutter-y-xs">
      <q-select v-model="Property.property_name" outlined label="Select Property" clearable :options="properties_options" />
      <div v-if="property_detail"><q-chip outline size="sm" square v-for="(val,name) in property_detail" :label="name + ': ' + val" /><q-btn href="https://www.rfc-editor.org/rfc/rfc2426" size="sm" outline label="rfc2426" dense padding="none sm" target="_blank" /></div>
      <div v-if="property_detail && Params.length" class="row q-col-gutter-xs">
        <div class="col" v-for="param in Params"><q-input outlined :label="param" v-model="Property.params[param]" /></div>
      </div>
      <q-input v-model="Property.name" outlined label="Name (no space)" />
      <q-select v-model="Property.type" :options="['layout','vcard']" label="Type" outlined />
      <div class="flex justify-around">
        <q-toggle v-model="Property.image" :false-value="0" :true-value="1" label="Its a Image URL" />
        <q-toggle v-model="Property.mandatory" :false-value="0" :true-value="1" label="Its a Mandatory Property" />
      </div>
      <q-input v-model="Property.value" label="Default Value" outlined />
      <q-input v-model="Property.description" label="Describe Property" outlined type="textarea" />
    </q-card-section>
    <q-card-actions align="between" class="bg-grey-1">
      <q-btn color="primary" @click="delProp" icon="delete" flat />
      <q-btn label="Update Property" color="primary" @click="save" />
    </q-card-actions>
    <InnerLoading :loading="loading" />
  </q-card>
</template>

<script setup>
import {usePropertyStore} from "stores/property.js";
import {computed, nextTick, onMounted, reactive, ref, watch} from "vue";
import {clone, map, zipObject} from "lodash";
import {useLayoutStore} from "stores/layout.js";
import InnerLoading from "components/InnerLoading.vue";

const props = defineProps(['layout_id','name'])
const emits = defineEmits(['close'])
const loading = ref(false)

const Property = reactive({ property_name:null,name:null,type:null,image:null,mandatory:null,value:null,params:null,description:null })
const Params = ref([])

const propertyStore = usePropertyStore(), layoutStore = useLayoutStore()
const properties_options = computed(() => propertyStore.Properties ?. map(Property => Property.name))
const layout_property_detail = computed(() => layoutStore.LayoutProperties(props.layout_id,props.name))
const property_detail = computed(() => propertyStore.PropertiesByPropertyName[Property.property_name || layout_property_detail.value?.property_name])
const vCard_params = computed(() => property_detail.value ? propertyStore.vCardParamsOfPropertyName(property_detail.value.property_name) : [])

function reset(){
  if(layout_property_detail.value){
    ['property_name','name','value','description','type'].map(key => Property[key] = layout_property_detail.value[key]);
    ['image','mandatory'].map(key => Property[key] = layout_property_detail.value[key] ? 1 : 0)
    Params.value = vCard_params.value
    Property.params = zipObject(Params.value,new Array(Params.value.length).fill(null))
    rearrangeAccordingToPropertyName(Property.property_name)
  } else {
    ['property_name','name','value','params','description'].map(key => Property[key] = null)
    Property.type = 'vcard'; ['image','mandatory'].map(key => Property[key] = 0)
    Params.value.slice(0,Params.value.length)
  }
  loading.value = false
}
onMounted(() => setTimeout(reset,1200))

function rearrangeAccordingToPropertyName(propName){
  if(!propName) return Params.value.slice(0,Params.value.length);
  Params.value = propertyStore.vCardParamsOfPropertyName(propName)
  Property.params = zipObject(Params.value,new Array(Params.value.length).fill(null))
  if(layout_property_detail.value.property_name === propName)
    map(layout_property_detail.value.params,(val,param) => Property.params[param] = val)
}
watch(() => Property.property_name,rearrangeAccordingToPropertyName)

function save(){
  loading.value = true
  let data = clone(Property); data.params = {}
  map(Property.params,(val,prop) => val ? data.params[prop] = val : null);
  layoutStore.updateLayoutProperty(props.layout_id,layout_property_detail.value.id,data).then(reset).then(close)
}
function delProp(){
  loading.value = true
  layoutStore.deleteLayoutProperty(props.layout_id,layout_property_detail.value.id).then(reset).then(close)
}
function close(){ emits('close') }
</script>
