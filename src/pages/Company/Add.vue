<template>
  <q-page padding class="q-gutter-sm">
    <q-card>
      <q-card-section class="bg-grey-2 text-bold">Add New Company</q-card-section>
      <q-card-section class="q-gutter-y-xs">
        <q-input v-model="newCompany.code" outlined label="Company Code (max 4 char)" />
        <q-input v-model="newCompany.name" outlined label="Company Name" />
        <q-input v-model="newCompany.base_url" outlined label="Base URL (ex: https://dbc.xnture.com)" />
        <q-select v-model="newCompany.layout_id" outlined label="Select Layout for Company" :options="layoutOptions" emit-value map-options />
        <div class="row q-mt-xs">
          <div class="col-8 q-col-gutter-y-xs">
            <q-input v-model="newCompany.logo_url" outlined label="Logo URL" />
            <div class="row q-col-gutter-x-xs">
              <div class="col-6"><q-input v-model="newCompany.logo_width" outlined label="Logo Width" /></div>
              <div class="col-6"><q-input v-model="newCompany.logo_height" outlined label="Logo Height" /></div>
            </div>
          </div>
          <div class="col-4 text-right"><q-img :src="newCompany.logo_url" v-if="newCompany.logo_url" fit="contain" class="full-width" /></div>
        </div>
        <div class="q-pa-sm text-bold bg-grey-2">Brand Color (Hexa code, ex: #FFFFFF)</div>
        <div class="row q-col-gutter-x-xs">
          <div class="col-6"><q-input v-model="newCompany.brand_primary" outlined label="Primary Brand Color (Hexa Value)" /></div>
          <div class="col-6"><q-input v-model="newCompany.brand_secondary" outlined label="Secondary Brand Color (Hexa Value)" /></div>
        </div>
        <div class="q-pa-sm text-bold bg-grey-2">Font Color (Hexa code, ex: #FFFFFF)</div>
        <div class="row q-col-gutter-x-xs">
          <div class="col-6"><q-input v-model="newCompany.color_primary" outlined label="Primary Color (Hexa Value)" /></div>
          <div class="col-6"><q-input v-model="newCompany.color_secondary" outlined label="Secondary Color (Hexa Value)" /></div>
        </div>
        <div class="q-pa-sm text-bold bg-grey-2">Font Name (Google font name)</div>
        <div class="row q-col-gutter-x-xs">
          <div class="col-6"><q-input v-model="newCompany.font_primary" outlined label="Primary Font" /></div>
          <div class="col-6"><q-input v-model="newCompany.font_secondary" outlined label="Secondary Font" /></div>
        </div>
      </q-card-section>
      <q-card-actions align="right" class="bg-grey-1">
        <q-btn label="Save Company" color="primary" @click="saveCompany" />
      </q-card-actions>
    </q-card>
    <InnerLoading :loading="loading" />
  </q-page>
</template>

<script setup>
import InnerLoading from "components/InnerLoading.vue";
import {computed, reactive, ref} from "vue";
import {useCompanyStore} from "stores/company.js";
import {every, map} from "lodash";
import {useLayoutStore} from "stores/layout.js";

const loading = ref(false)
const companyStore = useCompanyStore(), layoutStore = useLayoutStore()

const newCompany = reactive({ name:'',code:'',base_url:'',logo_url:'',logo_width:'',logo_height:'',brand_primary:'',brand_secondary:'',color_primary:'',color_secondary:'',font_primary:'',font_secondary:'',layout_id:'' })
const mandatory = ['name','code']

const layoutOptions = computed(() => map(layoutStore.Layouts,layout => ({ label:layout.name,value:layout.id })))

function saveCompany(){
  loading.value = true;
  if(every(mandatory,key => newCompany[key].trim() !== '')) companyStore.addNewCompany(newCompany).then(companyAdded)
  else loading.value = false
}
function companyAdded(){
  map(newCompany,(val,key) => newCompany[key] = '')
  loading.value = false;
}
</script>
