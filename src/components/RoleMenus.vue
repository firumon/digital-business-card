<template>
  <q-list>
    <template v-for="(menus,header) in role_menus">
      <q-item-label header>{{ header }}</q-item-label>
      <q-item v-for="menu in menus" clickable v-ripple :to="routes.pushRouteObj(menu.name)">
        <q-item-section avatar><q-icon :name="menu.icon" /></q-item-section>
        <q-item-section>{{ menu.label }}</q-item-section>
      </q-item>
      <q-separator />
    </template>
    <q-item-label header>Profile</q-item-label>
    <q-item clickable v-ripple :to="routes.pushRouteObj('profile')">
      <q-item-section avatar><q-icon name="manage_accounts" /></q-item-section>
      <q-item-section>Profile</q-item-section>
    </q-item>
    <q-item clickable v-ripple @click="logout">
      <q-item-section avatar><q-icon name="logout" /></q-item-section>
      <q-item-section>Logout</q-item-section>
    </q-item>
  </q-list>
</template>

<script setup>
import {computed, ref} from "vue";
import {useRoutes} from "src/composables/routes.js";

const routes = useRoutes()
const role_menus = computed(() => routes.menus.value)

function logout(){ location.href = LOGOUT_URL }
</script>
