<template>
  <div class="text-center">
    <div class="text-h5 text-bold text-uppercase">{{ name }}</div>
    <div class="text-bold">{{ propsValue.designation }}</div>
  </div>
</template>

<script setup>
import {inject} from "vue";

defineProps(['name'])
const propsValue = inject('propsValue')
</script>
