<template>
  <q-layout view="hHh lpR lFr">
    <q-header reveal elevated class="bg-primary text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />
        <q-toolbar-title>Developer</q-toolbar-title>
        <q-btn flat round dense icon="logout" href="/logout" />
      </q-toolbar>
    </q-header>

    <q-drawer v-model="drawer" side="left" elevated>
      <q-scroll-area style="height: calc(100% - 150px); margin-top: 150px; border-right: 1px solid #ddd">
        <q-list>
          <q-item v-for="menuItem in menus" clickable v-ripple :to="menuItem.to">
            <q-item-section avatar><q-icon :name="menuItem.icon" /></q-item-section>
            <q-item-section>{{ menuItem.label }}</q-item-section>
          </q-item>
        </q-list>
      </q-scroll-area >
      <q-img class="absolute-top" src="https://cdn.quasar.dev/img/material.png" style="height: 150px">
        <div class="absolute-bottom bg-transparent">
          <q-avatar size="56px" class="q-mb-sm">
            <img src="https://cdn.quasar.dev/img/boy-avatar.png">
          </q-avatar>
          <div class="text-weight-bold">Firose Hussain</div>
          <div>The Developer</div>
        </div>
      </q-img>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
    {{ $route }}
  </q-layout>
</template>

<script setup>
import {ref} from "vue";

const drawer = ref(false)
function toggleLeftDrawer(){ drawer.value = !drawer.value }

const menus = [
  { label:'Layouts',icon:'auto_awesome_mosaic',to:{ name:'layouts' } },
  { label:'Properties',icon:'fact_check',to:{ name:'properties' } },
]

</script>
