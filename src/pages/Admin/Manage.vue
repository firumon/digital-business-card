<template>
  <q-page padding>
    <q-card>
      <q-card-section class="q-gutter-y-xs">
        <q-input v-model="name" outlined label="Name" />
        <div class="row q-gutter-x-xs">
          <div class="col"><q-input v-model="email" outlined label="Email" /></div>
          <div class="col"><q-input v-model="password" outlined label="Password" /></div>
        </div>
        <q-btn label="Add Administrator" color="primary" @click="addAdministrator" />
      </q-card-section>
      <q-card-section class="text-bold bg-grey-1">Administrators</q-card-section>
      <q-list>
        <q-item v-for="(admin,idx) in admins" clickable>
          <q-item-section side>{{ idx+1 }}</q-item-section>
          <q-item-section>
            <q-item-label>{{ admin.name }}</q-item-label>
            <q-item-label caption>{{ admin.email }}</q-item-label>
          </q-item-section>
          <q-item-section side><q-btn icon="forward" color="green" flat round @click="manage(admin)" /></q-item-section>
        </q-item>
      </q-list>
    </q-card>
    <q-dialog v-model="manageMode"><UserManage :user_id="_manage" /></q-dialog>
    <InnerLoading :loading="loading" />
  </q-page>
</template>

<script setup>
import InnerLoading from "components/InnerLoading.vue";
import UserManage from "components/User/Manage.vue";
import {computed, ref} from "vue";
import {useUserStore} from "stores/user.js";
import {filter} from "lodash";

const userStore = useUserStore()
const name = ref(''), email = ref(''), password = ref('')

const loading = ref(false)
const _manage = ref(null)
const manageMode = computed({
  get:() => _manage.value !== null,
  set:(mode) => _manage.value = mode || null,
})

const admins = computed(() => filter(userStore.Users,user => user.role === 'Administrator'))

function addAdministrator(){
  loading.value = true
  userStore.addUser({ name:name.value,email:email.value,password:password.value },'Administrator').then(() => {
    name.value = ''; email.value = ''; password.value = '';
  }).then(() => loading.value = false)
}

function manage(admin){ _manage.value = admin.id }
</script>
