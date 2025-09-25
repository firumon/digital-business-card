<template>
  <q-item-label header class="bg-grey-3">Logo & Size</q-item-label>
  <q-item v-for="key in keys" :key="'las-'+key">
    <q-item-section>{{ startCase(key) }}</q-item-section>
    <q-item-section side v-if="key === 'url' && logo[key]"><q-avatar><q-img :src="logo[key]" /></q-avatar></q-item-section>
    <q-item-section side><q-input outlined v-model="logo[key]" @update:modelValue="updateLogo(key,$event)" /></q-item-section>
  </q-item>
  <q-inner-loading :showing="loading"><q-spinner-facebook size="xl" /></q-inner-loading>
</template>

<script setup>
import {ref} from "vue";
import {debounce} from "quasar";
import {get, startCase} from "lodash";
import {api} from "boot/axios.js";

const keys = ['url','width','height']

const logo = ref(get(__COMPANY,'logo',{}))
let loading = ref(false), tmeOut = null;

const updateLogo = debounce(function(field,value){
  loading.value = true; tmeOut = setTimeout(() => loading.value = false,5000)
  api('setting', { setting:'LGO',field,value }).then(function(data){
    loading.value = false; clearTimeout(tmeOut);
    __COMPANY.logo = data;
  })
},1200)
</script>
