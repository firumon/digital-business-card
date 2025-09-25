<template>
  <q-card v-if="user">
    <q-card-section class="text-bold bg-grey-2 flex items-center">{{ user.name }}<q-space /><q-btn icon="close" flat color="primary" v-close-popup dense /></q-card-section>
    <q-card-section class="q-gutter-y-xs">
      <q-input outlined label="Name" :model-value="data.name || user.name" @update:model-value="data.name = $event" />
      <q-input outlined label="Email" :model-value="data.email || user.email" @update:model-value="data.email = $event" />
      <div class="text-right"><q-btn label="Update" color="positive" @click="updateData" /></div>
    </q-card-section>
    <q-card-section class="text-bold bg-grey-2">Password</q-card-section>
    <q-card-section horizontal class="items-center">
      <q-card-section class="col-7"><q-input outlined label="Password" v-model="password" /></q-card-section>
      <q-card-section class="col-5"><q-btn label="Change Password" color="warning" @click="changePassword" /></q-card-section>
    </q-card-section>
    <InnerLoading :loading="loading" />
  </q-card>
</template>

<script setup>
import {computed, reactive, ref} from "vue";
import {useUserStore} from "stores/user.js";
import InnerLoading from "components/InnerLoading.vue";

const userStore = useUserStore()

const props = defineProps(['user_id'])
const data = reactive({ name:'',email:'' })
const password = ref('')
const user = computed(() => userStore.UsersById[props.user_id])

const loading = ref(false)

function updateData(){ loading.value = true; userStore.updateUserBasic(props.user_id,data).then(() => loading.value = false) }
function changePassword(){ loading.value = true; userStore.updateUserPassword(props.user_id,password.value).then(() => password.value = '').then(() => loading.value = false) }
</script>
