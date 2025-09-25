<template>
  <q-page padding class="q-gutter-y-xs">
    <ChooseCompanySelect label="Select Company" v-model="selected" v-if="!props.company_id" />
    <q-card>
      <q-card-section class="text-bold bg-grey-2">Company Properties</q-card-section>
      <q-list>
        <q-item v-for="property in LayoutProperties">
          <q-item-section>
            <q-item-label><q-input v-model="properties[property.name]" outlined :label="startCase(property.name)" /></q-item-label>
          </q-item-section>
          <q-item-section side><q-btn icon="info" flat dense color="secondary" padding="none" @click="info = property" /></q-item-section>
        </q-item>
      </q-list>
      <q-card-actions align="right" class="bg-grey-2">
        <q-btn color="primary" label="Save Properties" @click="SaveProperties" :disable="!companyId" />
      </q-card-actions>
    </q-card>
    <InnerLoading :loading="loading" />
    <q-dialog :model-value="info !== null" @before-hide="info = null" persistent>
      <q-card class="full-width">
        <q-bar><q-icon name="info" /><q-space /><q-btn dense flat icon="close" v-close-popup /></q-bar>
        <q-card-section>
          <p v-if="info.description">{{ info.description }}</p>
          <p v-if="Properties[info.property_name]?.description">{{ Properties[info.property_name].description }}</p>
          <p v-if="Properties[info.property_name]?.example">Ex: {{ Properties[info.property_name].example }}</p>
          <p v-if="info.value">Default Value: {{ info.value }}</p>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script setup>
import ChooseCompanySelect from "components/Company/ChooseCompanySelect.vue";
import {computed, ref, watch} from "vue";
import {useCompanyStore} from "stores/company.js";
import {useLayoutStore} from "stores/layout.js";
import {get, map, startCase} from "lodash";
import InnerLoading from "components/InnerLoading.vue";
import {usePropertyStore} from "stores/property.js";
import {useTitle} from "src/composables/title.js";

const companyStore = useCompanyStore(), layoutStore = useLayoutStore(), propertyStore = usePropertyStore()
const props = defineProps(['company_id'])

const selected = ref(props.company_id)
const loading = ref(false)
const properties = ref({})
const info = ref(null)

const Properties = computed(() => propertyStore.PropertiesByPropertyName)
const companyId = computed(() => selected.value || props.company_id)
const Company = computed(() => companyId.value ? companyStore.CompaniesById[companyId.value] : null)
const CompanyProperties = computed(() => Company.value ? companyStore.Properties(Company.value.id) : null)
const layoutId = computed(() => Company.value ?. layout_id)
const Layout = computed(() => layoutId.value ? layoutStore.LayoutsById[layoutId.value] : null)
const LayoutProperties = computed(() => Layout.value ? Layout.value.properties : null)

function LayoutPropsToCompanyProps(){
  properties.value = {}
  map(LayoutProperties.value,lProp => {
    properties.value[lProp.name] = get(CompanyProperties.value,lProp.name)
  })
}
watch(Company,LayoutPropsToCompanyProps,{ immediate:true })

function SaveProperties(){
  loading.value = true
  companyStore.syncCompanyProperties(companyId.value,properties.value).then(savedProperties)
}
function savedProperties(){
  LayoutPropsToCompanyProps()
  loading.value = false;
}
useTitle(Company)
</script>
