<template>
  <q-card>
    <q-card-section class="text-bold bg-grey-2 flex items-center">Add New Layout Property <q-space /><q-btn icon="close" color="negative" v-close-popup flat dense /></q-card-section>
    <q-card-section class="q-gutter-y-xs">
      <q-select v-model="Property.property_name" outlined label="Select Property" clearable :options="properties_options" />
      <div v-if="property_details"><q-chip outline size="sm" square v-for="(val,name) in property_details" :label="name + ': ' + val" /><q-btn href="https://www.rfc-editor.org/rfc/rfc2426" size="sm" outline label="rfc2426" dense padding="none sm" target="_blank" /></div>
      <div v-if="property_details && Params.length" class="row q-col-gutter-xs">
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
    <q-card-actions align="right" class="bg-grey-1"><q-btn label="Add Property" color="primary" @click="save" /></q-card-actions>
    <InnerLoading :loading="loading" />
  </q-card>
</template>

<script setup>
import {usePropertyStore} from "stores/property.js";
import {computed, onMounted, reactive, ref, watch} from "vue";
import {clone, map, zipObject} from "lodash";
import {useLayoutStore} from "stores/layout.js";
import InnerLoading from "components/InnerLoading.vue";

const props = defineProps(['layout_id'])
const loading = ref(false)

const Property = reactive({ property_name:null,name:null,type:null,image:null,mandatory:null,value:null,params:null,description:null })
const Params = ref([])

const propertyStore = usePropertyStore(), layoutStore = useLayoutStore()

const properties_options = computed(() => propertyStore.Properties ?. map(Property => Property.name))
const property_details = computed(() => Property.property_name ? propertyStore.PropertiesByPropertyName[Property.property_name] : null)

function reset(){
  ['property_name','name','value','params','description'].map(key => Property[key] = null)
  Property.type = 'vcard'; ['image','mandatory'].map(key => Property[key] = 0)
  Params.value.slice(0,Params.value.length)
  loading.value = false
}
onMounted(reset)
watch(() => Property.property_name,(propName) => {
  if(!propName) return Params.value.slice(0,Params.value.length);
  const details = property_details.value, v_card_id = details ? details.v_card_property_id : null;
  if(!v_card_id) return null;
  Params.value = propertyStore.VCardPropertiesById[v_card_id].parameters
  Property.params = zipObject(Params.value,new Array(Params.value.length).fill(null))
  Property.name = propName
})

function save(){
  loading.value = true
  let data = clone(Property); data.params = {}
  map(Property.params,(val,prop) => val ? data.params[prop] = val : null);
  layoutStore.addLayoutProperty(props.layout_id,data).then(reset)
}
</script>
