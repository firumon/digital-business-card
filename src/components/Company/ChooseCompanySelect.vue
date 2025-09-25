<template>
  <q-select :options="company_options" v-model="selected" outlined emit-value map-options />
</template>

<script setup>
import {computed} from "vue";
import {useCompanyStore} from "stores/company.js";

const props = defineProps(['modelValue'])
const emits = defineEmits(['update:modelValue'])

const companyStore = useCompanyStore();
const company_options = computed(() => companyStore.CompanySelectOptions)

const selected = computed({
  get:() => props.modelValue,
  set:(id) => emits('update:modelValue',id)
})
</script>
