<template>
  <q-card class="text-center">
    <q-card-section class="bg-primary text-white">
      <div class="text-uppercase text-h6 text-bold">{{ name }}</div>
      <div class="text-capitalize text-bold">{{ designation }}</div>
    </q-card-section>
    <q-card-section><QrcodeVue :value="url" :size="size" render-as="canvas" :level="level" /></q-card-section>
    <q-card-actions align="center" class="bg-grey-1"><a :href="url" target="_blank" class="text-primary text-caption">{{ url }}</a></q-card-actions>
  </q-card>
</template>

<script setup>
import QrcodeVue from "qrcode.vue";
defineProps(['name','designation','url','level','size'])
</script>
