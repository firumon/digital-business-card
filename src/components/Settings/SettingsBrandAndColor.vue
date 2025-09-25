<template>
  <q-item-label header class="bg-grey-3">Brand & Color</q-item-label>
  <q-item v-for="key in keys" :key="'bnc-'+key">
    <q-item-section>{{ startCase(key) }}</q-item-section>
    <q-item-section side><q-input outlined label="Brand" v-model="brand[key]" @update:modelValue="updateTheme('brand')" /></q-item-section>
    <q-item-section side><q-input outlined label="Color" v-model="color[key]" @update:modelValue="updateTheme('color')" /></q-item-section>
  </q-item>
</template>

<script setup>
import {ref} from "vue";
import {get, map, startCase} from "lodash";
import {api} from "boot/axios.js";
import {debounce} from "quasar";

const keys = ['primary','secondary','accent'], brand = ref({}), color = ref({})

map(keys,key => (brand.value[key] = get(__COMPANY.layout,['brand',key],null)) || (color.value[key] = get(__COMPANY.layout,['color',key],null)))
map(keys,function(key){
  brand.value[key] = get(__COMPANY.layout,['brand',key],null)
  color.value[key] = get(__COMPANY.layout,['color',key],null)
})

const updateTheme = debounce(function(item){
  let colors = {}, p = item === 'brand' ? brand.value : color.value;
  map(keys,key => p[key] ? colors[key] = p[key] : null)
  api('setting', { setting:'BC',item,colors }).then(function(layout){
    brand.value = layout.brand; color.value = layout.color;
    __COMPANY.layout.brand = brand.value; __COMPANY.layout.color = color.value;
  })
},1200)
</script>
