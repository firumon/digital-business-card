<template>
  <q-btn :label="label" class="full-width" outline :style="'color: '+ color" v-if="home" :to="{ name:'index' }" />
  <q-btn :label="label" class="full-width" outline :style="'color: '+ color" v-else />
</template>

<script setup>
defineProps(['label','home','color'])
</script>
