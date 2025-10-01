<template>
  <q-page padding class="q-gutter-sm">
    <q-card>
      <q-card-section class="bg-grey-2 text-bold justify-between items-center flex"> Add Property <q-btn icon="menu" dense flat rounded @click="togglePropMenu" /></q-card-section>
      <q-card-section v-show="propMenu" class="col-xs-12"><PropertiesList @tap="tapped" /></q-card-section>
      <q-card-section v-if="!propMenu">
        <div class="row" v-if="tappedMaster"><div class="col col-3">{{ tappedMaster.property }}</div><div class="col col-9 text-caption">{{ tappedMaster.example }}</div><div class="col-3 col">&nbsp;</div><div class="col-9 text-caption">{{ tappedMaster.description }}</div></div>
        <div class="row q-col-gutter-xs items-center">
          <div class="col-12"><q-input label="Name (No Space)" v-model="Property.name" outlined /></div>
          <div class="col-12"><q-input label="Description" v-model="Property.description" outlined /></div>
          <div class="col-12"><q-input label="Example" v-model="Property.example" outlined /></div>
          <div class="col" v-if="Object.values(Params).length" v-for="(paramVal,param) in Params"><q-input :label="param" v-model="Params[param]" outlined /></div>
          <div class="col-12"> </div>
          <div class="col-8"><q-input label="Default Value" v-model="Property.value" outlined /></div>
          <div class="col-4 text-right"><q-btn color="primary" label="Save" size="lg" class="full-width" @click="SaveProperty" /></div>
        </div>
      </q-card-section>
    </q-card>
    <ListPropertiesOfVCardId v-if="listPropId" :id="listPropId" :name="listPropName" />
    <InnerLoading :loading="loading" />
  </q-page>
</template>

<script setup>
import PropertiesList from "components/VCard/PropertiesList.vue";
import {reactive, ref} from "vue";
import {forEach} from "lodash";
import InnerLoading from "components/InnerLoading.vue";
import ListPropertiesOfVCardId from "pages/Property/ListPropertiesOfVCardId.vue";
import {usePropertyStore} from "stores/property.js";

const propertyStore = usePropertyStore()

const loading = ref(false), propMenu = ref(false)
function togglePropMenu(){ propMenu.value = !propMenu.value }

const Property = reactive({ v_card_property_id:'',name:'',value:'',params: {},description:'',example:'' })
const tappedMaster = ref(null), Params = ref({})
const listPropId = ref(null), listPropName = ref(null)

function tapped(Prop){
  tappedMaster.value = Prop
  Params.value = {}
  Property.v_card_property_id = Prop.id
  listPropId.value = Prop.id
  listPropName.value = Prop.property
  Prop.parameters.map(param => Params.value[param] = null)
  togglePropMenu()
}

function SaveProperty(){
  loading.value = true
  let params = {};
  forEach(Params.value,(value,param) => value ? (params[param] = value) : null)
  let data = Object.assign({},Property, { params })
  propertyStore.addNewProperty(data).then(() => loading.value = false).then(reset)
}
function reset(){
  forEach(Property,(value,prop) => Property[prop] = prop === 'params' ? {} : '');
  Params.value = {}
  tappedMaster.value = null
}
</script>
