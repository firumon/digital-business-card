<template>
  <q-layout view="hHh lpR fFf">

    <q-page-container>
      <router-view />
    </q-page-container>

    <q-footer elevated>
      <q-tabs v-model="tab" align="justify" switch-indicator>
        <q-route-tab exact :to="{ name:'individuals' }" name="individuals" label="Individuals" />
        <q-route-tab exact :to="{ name:'settings' }" name="settings" label="Settings" />
      </q-tabs>
    </q-footer>

  </q-layout>
</template>

<script setup>
import {ref} from "vue";

const tab = ref('')
</script>
