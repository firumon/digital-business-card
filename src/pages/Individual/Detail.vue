<template>
  <q-page padding class="q-gutter-y-sm">
    <div class="flex q-gutter-x-sm">
      <div class="col-grow"><q-input v-model="name" label="Name" outlined /></div>
      <q-btn icon="forward" color="primary" @click="updateName" />
    </div>
    <q-card>
      <q-card-section class="text-bold bg-grey-2">Individual Properties</q-card-section>
      <q-list>
        <template v-for="property in LayoutPropertiesVCard">
          <q-item v-if="!CompanyProperties[property.name]">
            <q-item-section>
              <q-input :modelValue="propertyValue[property.name]" @update:modelValue="updateModelValue(property.name,$event)" :label="startCase(property.name)" outlined />
            </q-item-section>
          </q-item>
        </template>
        <template v-for="property in LayoutPropertiesLayout">
          <q-item v-if="!CompanyProperties[property.name]">
            <q-item-section>
              <q-input :modelValue="propertyValue[property.name]" @update:modelValue="updateModelValue(property.name,$event)" :label="startCase(property.name)" outlined />
            </q-item-section>
          </q-item>
        </template>
      </q-list>
      <q-card-section class="text-bold bg-grey-2">Company Properties</q-card-section>
      <q-list>
        <template v-for="property in LayoutPropertiesVCard">
          <q-item v-if="CompanyProperties[property.name]">
            <q-item-section>
              <q-input :modelValue="propertyValue[property.name]" @update:modelValue="updateModelValue(property.name,$event)" :label="startCase(property.name)" outlined />
            </q-item-section>
          </q-item>
        </template>
        <template v-for="property in LayoutPropertiesLayout">
          <q-item v-if="CompanyProperties[property.name]">
            <q-item-section>
              <q-input :modelValue="propertyValue[property.name]" @update:modelValue="updateModelValue(property.name,$event)" :label="startCase(property.name)" outlined />
            </q-item-section>
          </q-item>
        </template>
      </q-list>
      <q-card-actions align="right" class="bg-grey-2">
        <q-btn color="primary" label="Update Properties" @click="updateProperties" />
      </q-card-actions>
    </q-card>
    <InnerLoading :loading="loading" />
  </q-page>
</template>

<script setup>
import {computed, ref, watch} from "vue";
import {useCompanyStore} from "stores/company.js";
import {useLayoutStore} from "stores/layout.js";
import InnerLoading from "components/InnerLoading.vue";
import {filter, keyBy, map, mapValues, startCase} from "lodash";
import {useTitle} from "src/composables/title.js";

const companyStore = useCompanyStore(), layoutStore = useLayoutStore()

const props = defineProps(['company_id','individual_id'])

const loading = ref(false)
const name = ref('')
const properties = ref({})

const Company = computed(() => companyStore.CompaniesById ?. [props.company_id])
const Individual = computed(() => companyStore.Individual(props.company_id,props.individual_id))
const Layout = computed(() => layoutStore.LayoutsById ?. [Company.value ?. layout_id])
const CompanyProperties = computed(() => Company.value ? companyStore.Properties(Company.value.id) : {})
const IndividualProperties = computed(() => (Company.value && Individual.value) ? companyStore.IndividualProperties(Company.value.id,Individual.value.id) : {})
const LayoutPropertiesArray = computed(() => Layout.value ? layoutStore.LayoutProperties(Layout.value.id,null) : [])
const LayoutPropertiesVCard = computed(() => filter(LayoutPropertiesArray.value,['type','vcard']))
const LayoutPropertiesLayout = computed(() => filter(LayoutPropertiesArray.value,['type','layout']))
const LayoutPropertiesKeyed = computed(() => keyBy(LayoutPropertiesArray.value,'name'))

const propertyValue = computed(() => mapValues(LayoutPropertiesKeyed.value,({ name,value }) => properties.value[name] || CompanyProperties.value[name] || value))
function updateModelValue(name,value){ properties.value[name] = value }

watch(Individual,individual => name.value = individual ?. name || '',{ immediate:true })
watch([LayoutPropertiesArray,CompanyProperties,IndividualProperties],function(changes){
  let lpAry = changes[0]; properties.value = {}; map(lpAry,lp => properties.value[lp.name] = '')
  map(IndividualProperties.value,(val,key) => properties.value[key] = val)
},{ immediate:true })

function updateName(){
  loading.value = true;
  companyStore.updateIndividualName(props.company_id,props.individual_id,name.value).then(() => loading.value = false)
}
function updateProperties(){
  loading.value = true;
  companyStore.updateIndividualProperties(props.company_id,props.individual_id,properties.value).then(() => loading.value = false)
}
useTitle(Individual)
</script>
