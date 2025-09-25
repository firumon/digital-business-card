<template>
  <q-item-label header class="bg-grey-3">Attributes</q-item-label>
  <q-item v-for="param in params" :key="'apr-'+param.id">
    <q-item-section>{{ startCase(param.attr) }}</q-item-section>
    <q-item-section side><q-input outlined v-model="values[param.attr]" @update:modelValue="updateParam(param.attr,$event)" /></q-item-section>
    <q-item-section side><HelpTipDescPopup :description="param.description" /></q-item-section>
  </q-item>
  <q-inner-loading :showing="loading"><q-spinner-facebook size="xl" /></q-inner-loading>
</template>

<script setup>
import HelpTipDescPopup from "components/HelpTipDescPopup.vue";
import {ref} from "vue";
import {debounce} from "quasar";
import {filter, map, startCase, zipObject} from "lodash";
import {api} from "boot/axios.js";

const params = ref(filter(__COMPANY.layout.master.attrs,attr => attr.individual === false))
const values = ref(zipObject(map(__COMPANY.params,'param'),map(__COMPANY.params,'value')))
let loading = ref(false), tmeOut = null;

const updateParam = debounce(function(param,value){
  loading.value = true; tmeOut = setTimeout(() => loading.value = false,5000)
  api('setting', { setting:'APR',param,value }).then(function(data){
    loading.value = false; clearTimeout(tmeOut);
    __COMPANY.params = data;
  })
},1200)
</script>
