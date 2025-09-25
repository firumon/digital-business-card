<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated v-if="header">
      <q-toolbar>
        <q-btn flat dense round icon="menu" aria-label="Menu" />
        <q-toolbar-title>Quasar App</q-toolbar-title>
        <div>Quasar Version</div>
      </q-toolbar>
    </q-header>
    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import {computed} from "vue";
import {get} from "lodash";

const header = computed(() => get(__DATA,['layout','header'],false) || false)
</script>
