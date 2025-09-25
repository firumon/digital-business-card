<template>
  <div class="text-center">
    <div class="text-h5 text-bold text-uppercase">{{ name }}</div>
    <div class="text-bold">{{ designation }}</div>
  </div>
</template>

<script setup>
defineProps(['name','designation'])
</script>
