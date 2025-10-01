<template>
  <div class="text-center q-py-md q-px-xl q-gutter-y-sm" v-if="enabled">
    <CompanyButton v-for="label in labels" :label="label" :color="color" />
  </div>
</template>

<script setup>
import CompanyButton from "components/Cards/EliteCard/CompanyButton.vue";
import {computed} from "vue";

defineProps(['color'])

const labels = ["Book An Appointment","Schedule A consultation","About Us"]
const enabled = labels.length > 0
</script>
