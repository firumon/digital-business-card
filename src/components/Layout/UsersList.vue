<template>
  <q-card>
    <q-card-section class="bg-grey-2 text-bold">Users</q-card-section>
    <q-list v-if="UsersOnly.length || UsersExcept.length" dense>
      <template v-if="UsersOnly.length">
        <q-item-label header>Access Only to Users</q-item-label>
        <q-item v-for="(userId,idx) in UsersOnly">
          <q-item-section side>{{ idx+1 }}</q-item-section>
          <q-item-section>{{ Users[userId] ?. name }}</q-item-section>
        </q-item>
      </template>
      <template v-if="UsersExcept.length">
        <q-item-label header>Access Restricted to Users</q-item-label>
        <q-item v-for="(userId,idx) in UsersExcept">
          <q-item-section side>{{ idx+1 }}</q-item-section>
          <q-item-section>{{ Users[userId] ?. name }}</q-item-section>
        </q-item>
      </template>
    </q-list>
  </q-card>
</template>

<script setup>
import {useUserStore} from "stores/user.js";
import {useLayoutStore} from "stores/layout.js";
import {computed} from "vue";

const props = defineProps(['layout_id'])

const userStore = useUserStore(), layoutStore = useLayoutStore();
const UsersOnly = computed(() => layoutStore.LayoutsById ?. [props.layout_id] ?. users_only || [])
const UsersExcept = computed(() => layoutStore.LayoutsById ?. [props.layout_id] ?. users_except || [])
const Users = computed(() => userStore.UsersById)
</script>
