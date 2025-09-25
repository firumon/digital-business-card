<template>
  <div class="row q-col-gutter-sm">
    <div class="col-6"><q-input outlined label="QR Side" v-model.number="size" type="number" /></div>
    <div class="col-6"><q-select outlined label="Error Correction Level" v-model="level" :options="levels" /></div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2" v-for="individual in individuals" :key="individual.code">
      <IndividualQRCode v-bind="individual" :size="size" :level="level" />
    </div>
  </div>
</template>

<script setup>
import {api} from "boot/axios.js";
import {ref} from "vue";
import {normalizeUrl} from "assets/helper.js";
import {forEach} from "lodash";
import IndividualQRCode from "components/Individual/IndividualQRCode.vue";

const props = defineProps(['company_code'])
const levels = ['L','M','Q','H'], level = ref(levels[0]), size = ref(300)
const base_url = ref('https://dbc.xnture.com')
const individuals = ref([])
api(`${props.company_code}/individuals_urls`).then(function(company){
  base_url.value = normalizeUrl(company['base_url']);
  forEach(company['individuals'],function({ code,name,designation }){
    let url = [base_url.value,code].join('/')
    individuals.value.push({ code,name,designation,url })
  })
})
</script>
