<template>
  <q-page padding>
    <div v-if="managerId">
      <div class="flex items-center q-pl-sm text-bold q-mb-md">{{ Manager.name }}<q-space /><q-btn label="Change Manager" color="secondary" outline no-caps @click="selectedManager = null" /></div>
      <ChooseCompaniesCardList :manager_id="Manager.id" />
    </div>
    <ChooseManagerCardList v-else v-model="selectedManager" />
  </q-page>
</template>

<script setup>
import ChooseManagerCardList from "components/Manager/ChooseManagerCardList.vue";
import ChooseCompaniesCardList from "components/Manager/ChooseCompaniesCardList.vue";
import {useUserStore} from "stores/user.js";
import {computed, ref} from "vue";

const userStore = useUserStore()

const props = defineProps(['manager_id'])
const selectedManager = ref(null)

const managerId = computed(() => selectedManager.value || props.manager_id)
const Manager = computed(() => managerId.value ? userStore.UsersById[managerId.value] : null)

</script>
