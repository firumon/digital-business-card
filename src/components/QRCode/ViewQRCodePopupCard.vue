<template>
  <q-card square class="bg-grey-3">
    <q-bar class="q-py-lg">
      <q-btn icon="download" flat @click="downloadPDF" /><q-space />
      <q-btn-group push glossy><q-btn v-for="l in ['L','M','Q','H']" :label="l" @click="level = l" padding="xs sm" /></q-btn-group> <q-space />
      <q-btn-group push glossy><q-btn padding="none sm" icon="text_decrease" @click="size -= parseInt(screen.width * 0.05)" /><q-btn padding="xs sm" :label="size" /><q-btn padding="none sm" icon="text_increase" @click="size += parseInt(screen.width * 0.05)" /></q-btn-group> <q-space />
      <q-btn icon="close" v-close-popup flat />
    </q-bar>
    <q-card-section ref="qrCodeDiv">
      <q-card-section class="bg-white text-center q-mb-sm q-py-lg" v-for="Individual in Individuals" style="page-break-after: always;">
        <QrcodeVue :value="individualUrl(Individual)" :size="size" render-as="canvas" :level="level" />
        <div class="q-mt-md text-body1">{{ Individual.name }}</div>
        <a :href="individualUrl(Individual)" target="_blank" class="text-subtitle2">{{ individualUrl(Individual) }}</a>
      </q-card-section>
    </q-card-section>
  </q-card>
</template>

<script setup>
import {computed, ref, useTemplateRef} from "vue";
import {useCompanyStore} from "stores/company.js";
import {filter} from "lodash";
import QrcodeVue from "qrcode.vue";
import {useQuasar} from "quasar";
import html2pdf from "html2pdf.js";

const companyStore = useCompanyStore(), screen = useQuasar().screen
const props = defineProps(['individual_ids','company_id'])
const size = ref(parseInt(screen.width * 0.65)), level = ref('M')
const Company = computed(() => companyStore.CompaniesById[props.company_id])
const Individuals = computed(() => filter(Company.value ?. individuals || [],({ id }) => props.individual_ids.includes(id)))
const qrCodeDiv = useTemplateRef('qrCodeDiv')

function individualUrl({ code }){ return [Company.value.base_url,code].join("/") }

function downloadPDF(){
  let worker = new html2pdf();
  worker.from(qrCodeDiv.value.$el).save(Company.value.name + " Individuals QR Code.pdf")
}
</script>
