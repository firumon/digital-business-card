<template>
  <q-layout view="hHh lpR lFr">
    <q-header reveal elevated class="bg-primary text-white">
      <q-toolbar>
        <q-btn flat round dense icon="arrow_back_ios_new" @click="$router.back()" />
        <q-toolbar-title>{{ title }}</q-toolbar-title>
        <q-btn flat round dense icon="home" :to="{ name:'index' }" />
        <q-btn dense flat round icon="menu" @click="toggleDrawer" />
      </q-toolbar>
    </q-header>

    <q-drawer v-model="drawer" side="right" elevated>
      <q-scroll-area style="height: calc(100% - 150px); margin-top: 150px; border-right: 1px solid #ddd">
        <RoleMenus />
      </q-scroll-area >
      <q-img class="absolute-top" src="https://cdn.quasar.dev/img/material.png" style="height: 150px">
        <div class="absolute-bottom bg-transparent">
          <q-avatar size="56px" class="q-mb-sm">
            <img src="https://cdn.quasar.dev/img/boy-avatar.png" >
          </q-avatar>
          <div class="text-weight-bold">{{ user.name }}</div>
          <div>The {{ user.role }}</div>
        </div>
      </q-img>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>

  </q-layout>
</template>

<script setup>
import {computed, provide, ref} from "vue";
import RoleMenus from "components/RoleMenus.vue";
import {useUserStore} from "stores/user.js";
import {useRoutes} from "src/composables/routes.js";
import {onBeforeRouteUpdate} from "vue-router";

const drawer = ref(false)
function toggleDrawer(){ drawer.value = !drawer.value }

const { pageTitle, setTitleResource } = useRoutes();
const userStore = useUserStore()
const user = computed(() => userStore.User)
const title = computed(() => pageTitle.value)
provide('setTitleResource',setTitleResource)
onBeforeRouteUpdate(() => setTitleResource(null))
</script>
