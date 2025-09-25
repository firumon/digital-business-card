<template>
  <q-separator v-if="separate !== false" />
  <div class="q-my-md q-px-md" >
    <q-input v-model="value" outlined />
    <div class="q-mt-sm" v-if="image">
      <q-img :src="value" fit="contain" height="100px" />
    </div>
  </div>
</template>

<script setup>
defineProps(['separate','image'])
const value = defineModel()
</script>
