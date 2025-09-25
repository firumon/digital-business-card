<template>
  <q-btn icon="help" dense flat padding="none" size="sm" color="grey-5">
    <q-popup-proxy>
      <q-card>
        <q-card-section>{{ description }}</q-card-section>
        <q-card-section class="bg-primary q-py-xs"></q-card-section>
      </q-card>
    </q-popup-proxy>
  </q-btn>
</template>

<script setup>
defineProps(['description'])
</script>
