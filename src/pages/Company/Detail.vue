<template>
  <q-page padding class="q-gutter-y-sm">
    <q-card>
      <q-card-section class="bg-grey-2 text-bold">Update Details</q-card-section>
      <q-card-section class="q-gutter-y-xs">
        <q-input v-model="updates.code" outlined label="Company Code (max 4 char)" />
        <q-input v-model="updates.name" outlined label="Company Name" />
        <q-input v-model="updates.base_url" outlined label="Base URL (ex: https://dbc.xnture.com)" />
        <q-select v-model="updates.layout_id" outlined label="Select Layout for Company" :options="layoutOptions" emit-value map-options />
        <div class="row q-mt-xs">
          <div class="col-8 q-col-gutter-y-xs">
            <q-input v-model="updates.logo_url" outlined label="Logo URL" />
            <div class="row q-col-gutter-x-xs">
              <div class="col-6"><q-input v-model="updates.logo_width" outlined label="Logo Width" /></div>
              <div class="col-6"><q-input v-model="updates.logo_height" outlined label="Logo Height" /></div>
            </div>
          </div>
          <div class="col-4 text-right"><q-img :src="updates.logo_url" v-if="updates.logo_url" fit="contain" class="full-width" /></div>
        </div>
        <div class="q-pa-sm text-bold bg-grey-2">Brand Color (Hexa code, ex: #FFFFFF)</div>
        <div class="row q-col-gutter-x-xs">
          <div class="col-6"><q-input v-model="updates.brand_primary" outlined label="Primary Color" /></div>
          <div class="col-6"><q-input v-model="updates.brand_secondary" outlined label="Secondary Color" /></div>
        </div>
        <div class="q-pa-sm text-bold bg-grey-2">Font Color (Hexa code, ex: #FFFFFF)</div>
        <div class="row q-col-gutter-x-xs">
          <div class="col-6"><q-input v-model="updates.color_primary" outlined label="Primary Color" /></div>
          <div class="col-6"><q-input v-model="updates.color_secondary" outlined label="Secondary Color" /></div>
        </div>
        <div class="q-pa-sm text-bold bg-grey-2">Font Name (Google font name)</div>
        <div class="row q-col-gutter-x-xs">
          <div class="col-6"><q-input v-model="updates.font_primary" outlined label="Primary Font" /></div>
          <div class="col-6"><q-input v-model="updates.font_secondary" outlined label="Secondary Font" /></div>
        </div>
      </q-card-section>
      <q-card-actions align="right" class="bg-grey-1">
        <q-btn label="Save Changes" color="primary" @click="updateCompany" />
      </q-card-actions>
    </q-card>
    <InnerLoading :loading="loading" />
  </q-page>
</template>

<script setup>
import InnerLoading from "components/InnerLoading.vue";
import {useLayoutStore} from "stores/layout.js";
import {computed, reactive, ref, watch} from "vue";
import {map} from "lodash";
import {useCompanyStore} from "stores/company.js";
import {useTitle} from "src/composables/title.js";

const companyStore = useCompanyStore(), layoutStore = useLayoutStore()
const props = defineProps(['id'])
const loading = ref(false)

const updates = reactive({ name:'',code:'',base_url:'',logo_url:'',logo_width:'',logo_height:'',brand_primary:'',brand_secondary:'',color_primary:'',color_secondary:'',font_primary:'',font_secondary:'',layout_id:'' })
const layoutOptions = computed(() => layoutStore.selectOptions)
const Company = computed(() => companyStore.CompaniesById[props.id])

function companyToUpdates(){ map(updates,(val,key) => updates[key] = Company.value ?. [key] || '') }
watch(Company,companyToUpdates,{ immediate:true })

function updateCompany(){
  loading.value = true;
  companyStore.updateCompany(props.id,updates).then(() => loading.value = false)
}
useTitle(Company)
</script>
