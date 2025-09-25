<template>
  <q-page padding class="q-gutter-y-xs">
    <ChooseLayoutSelect label="Select Layout" v-model="selected" v-if="!props.layout_id" />
    <q-card>
      <q-card-section class="text-bold bg-grey-2 flex items-center">
        Layout Users <q-space />
        <q-input v-model="filterText" dense outlined label="Filter" />
      </q-card-section>
      <q-list>
        <q-item v-for="(user,idx) in filteredUsers">
          <q-item-section side><q-checkbox v-model="accessUsers" :val="user.id" /></q-item-section>
          <q-item-section>
            <q-item-label>{{ idx+1 }}. {{ user.name }}</q-item-label>
            <q-item-label caption>{{ user.email }}</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
      <q-card-actions align="right" class="bg-grey-1">
        <q-btn label="Update Users" color="primary" padding="sm lg" @click="update" :disable="!layoutId" />
      </q-card-actions>
    </q-card>
    <InnerLoading :loading="loading" />
  </q-page>
</template>

<script setup>
import ChooseLayoutSelect from "components/Layout/ChooseLayoutSelect.vue";
import {useLayoutStore} from "stores/layout.js";
import {computed, ref, watch} from "vue";
import {useUserStore} from "stores/user.js";
import InnerLoading from "components/InnerLoading.vue";
import {filter, find, get} from "lodash";
import {useTitle} from "src/composables/title.js";

const layoutStore = useLayoutStore(), userStore = useUserStore()
const props = defineProps(['layout_id'])

const roleRole = { Developer:'Administrator',Administrator:'Reseller' }
const user = computed(() => userStore.User), role = computed(() => roleRole[user.value.role])

const selected = ref(props.layout_id)
const loading = ref(false), filterText = ref('')
const accessUsers = ref(null)

const layoutId = computed(() => selected.value || props.layout_id)
const Layout = computed(() => layoutId.value ? layoutStore.LayoutsById[layoutId.value] : null)
const LayoutUsers = computed(() => role.value === 'Administrator' ? (Layout.value ?. admins || []) : (Layout.value ?. users))
const LayoutUsersArray = computed(() => role.value === 'Administrator' ? LayoutUsers.value : get(find(LayoutUsers.value,['user_id',user.value.id]),'resellers',[]))
const appUsers = computed(() => filter(userStore.Users,({ role:userRole }) => role.value === userRole))
const filteredUsers = computed(() => filterText.value ? filter(appUsers.value,user => [user.id,user.name,user.email].join(' ').toLowerCase().includes(filterText.value.toLowerCase())) : appUsers.value )
watch(LayoutUsersArray,(users) => accessUsers.value = users,{ immediate:true })

function update(){
  loading.value = true;
  layoutStore.updateUsers(layoutId.value,accessUsers.value,role.value).then(() => loading.value = false)
}
useTitle(Layout)
</script>
