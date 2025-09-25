<template>
  <q-page padding>
    <div v-if="resellerId">
      <div class="flex items-center q-pl-sm text-bold q-mb-md">{{ Reseller.name }}<q-space /><q-btn label="Change Reseller" color="secondary" outline no-caps @click="selectedReseller = null" /></div>
      <ChooseCompaniesCardList :reseller_id="Reseller.id" />
    </div>
    <ChooseResellerCardList v-else v-model="selectedReseller" />
  </q-page>
</template>

<script setup>
import ChooseResellerCardList from "components/Reseller/ChooseResellerCardList.vue";
import ChooseCompaniesCardList from "components/Reseller/ChooseCompaniesCardList.vue";
import {useUserStore} from "stores/user.js";
import {computed, ref} from "vue";

const userStore = useUserStore()

const props = defineProps(['reseller_id'])
const selectedReseller = ref(null)

const resellerId = computed(() => selectedReseller.value || props.reseller_id)
const Reseller = computed(() => resellerId.value ? userStore.UsersById[resellerId.value] : null)

</script>
