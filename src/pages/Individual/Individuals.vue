<template>
  <q-page padding>
    <q-card>
      <q-card-section class="text-bold bg-grey-2 flex items-center">Individuals<q-space /><q-chip :label="Individuals ?. length || 0" class="q-ma-none" /></q-card-section>
      <q-list separator>
        <q-item v-for="Individual in Individuals">
          <q-item-section side><q-checkbox v-model="selectedIndividuals" :val="Individual.id" /></q-item-section>
          <q-item-section>
            <q-item-label caption>{{ Individual.code }}</q-item-label>
            <q-item-label>{{ Individual.name }}</q-item-label>
          </q-item-section>
          <q-item-section side><q-btn dense icon="forward" flat color="primary" @click="routes.push('company_individual',Individual)" /></q-item-section>
        </q-item>
        <q-item v-if="selectedIndividuals.length" clickable v-ripple @click="viewQRCodes = true">
          <q-item-section side><q-chip :label="selectedIndividuals.length" /></q-item-section>
          <q-item-section>View QR Code</q-item-section>
          <q-item-section side><q-btn dense icon="qr_code" flat color="primary" /></q-item-section>
        </q-item>
      </q-list>
    </q-card>
    <q-dialog persistent :maximized="true" v-model="viewQRCodes"><ViewQRCodePopupCard :individual_ids="selectedIndividuals" :company_id="props.company_id" /></q-dialog>
    <InnerLoading :loading="loading" />
  </q-page>
</template>

<script setup>
import InnerLoading from "components/InnerLoading.vue";
import {computed, reactive, ref} from "vue";
import {useCompanyStore} from "stores/company.js";
import ViewQRCodePopupCard from "components/QRCode/ViewQRCodePopupCard.vue";
import IndividualUsersManage from "components/Individual/IndividualUsersManage.vue";
import {useRoutes} from "src/composables/routes.js";
import {useTitle} from "src/composables/title.js";

const companyStore = useCompanyStore(), routes = useRoutes()
const props = defineProps(['company_id'])

const Company = computed(() => companyStore.CompaniesById[props.company_id])
const Individuals = computed(() => Company.value ?. ['individuals'])

const newIndividual = reactive({ name:'' })
const selectedIndividuals = ref([])

const loading = ref(false)
const viewQRCodes = ref(false)

const individualLogin = ref(null)

function addNewIndividual(){
  loading.value = true
  companyStore.addIndividual(props.company_id,newIndividual.name).then(addedIndividual)
}
function addedIndividual(){
  newIndividual.name = ''
  loading.value = false;
}

function manageLogin({ id }){
  individualLogin.value = id
}

useTitle(Company)
</script>
