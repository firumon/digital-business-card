<template>
  <q-card>
    <q-bar><q-icon name="lens_blur" /><q-space /><q-btn icon="close" v-close-popup flat color="primary" dense round /></q-bar>
    <q-card-section class="q-gutter-y-xs">
      <q-input :model-value="updates.name || props.user.name" label="Name" outlined @update:modelValue="updates.name = $event" />
      <q-input :model-value="updates.email || props.user.email" label="Email" outlined @update:modelValue="updates.email = $event" />
      <q-input :model-value="updates.password" label="Password" outlined hint="Leave password empty if no changes" @update:modelValue="updates.password = $event" />
      <q-btn color="primary" padding="sm lg" label="Update User" @click="updateUser" />
    </q-card-section>
    <InnerLoading :loading="loading" />
  </q-card>
</template>

<script setup>
import {ref} from "vue";
import InnerLoading from "components/InnerLoading.vue";
import {useUserStore} from "stores/user.js";

const userStore = useUserStore()

const props = defineProps(['user']), emits = defineEmits(['close'])
const updates = ref({ name:'',email:'',password:'' })
const loading = ref(false)

function updateUser(){
  loading.value = true;
  if(updates.value.name.trim() === '' && updates.value.email.trim() === '' && updates.value.password.trim() === '') return loading.value = false;
  if(updates.value.password.trim() !== '') userStore.updateUserPassword(props.user.id,updates.value.password).then(done)
  if(updates.value.name || updates.value.email) userStore.updateUserBasic(props.user.id,{ name:(updates.value.name || props.user.name),email:(updates.value.email || props.user.email) }).then(done)
}
function done(){
  ['name','email','password'].map(k => updates.value[k] = '')
  loading.value = false;
  emits('close')
}
</script>
