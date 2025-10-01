<template>
  <q-btn :label="label" class="full-width" outline :style="'color: '+ color" v-if="label === 'About Us'" :to="{ name:'index' }" />
  <q-btn :label="label" class="full-width" outline :style="'color: '+ color" v-else />
</template>

<script setup>
defineProps(['label','color'])
</script>
