<template>
  <q-inner-loading :showing="loading"><q-spinner-facebook size="xl" color="secondary" /></q-inner-loading>
</template>

<script setup>
defineProps(['loading'])
</script>
