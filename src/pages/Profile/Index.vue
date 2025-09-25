<template>
  <q-page padding>
    <q-card>
      <q-card-section class="q-gutter-y-xs">
        <q-input label="Name" outlined :modelValue="basic.name || user.name" @update:modelValue="basic.name = $event" />
        <q-input label="Email" outlined :modelValue="basic.email || user.email" @update:modelValue="basic.email = $event" />
        <q-btn label="Update Details" color="primary" @click="updateDetails" />
      </q-card-section>
      <q-card-section class="bg-grey-2 text-bold">Change Password</q-card-section>
      <q-card-section horizontal>
        <q-card-section class="col-8"><q-input type="password" label="New Password" outlined v-model="password" /></q-card-section>
        <q-card-section class="col-4"><q-btn color="primary" label="Update Password" :disable="!password" @click="changePassword" /></q-card-section>
      </q-card-section>
    </q-card>
    <InnerLoading :loading="loading" />
  </q-page>
</template>

<script setup>
import {computed, reactive, ref} from "vue";
import {useUserStore} from "stores/user.js";
import InnerLoading from "components/InnerLoading.vue";

const userStore = useUserStore()

const loading = ref(false)

const user = computed(() => userStore.User)
const basic = reactive({ name:'',email:'' })
const password = ref('')

function changePassword(){ loading.value = true; userStore.updateProfilePassword(password.value).then(() => password.value = '').then(() => loading.value = false) }
function updateDetails(){ loading.value = true; userStore.updateProfileBasic(basic).then(() => loading.value = false) }
</script>
