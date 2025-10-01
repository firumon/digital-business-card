<template>
  <div class="q-px-xl">
    <q-btn label="Save me as a Contact" :style="style" class="full-width glossy" icon="download" @click="download" />
  </div>
</template>

<script setup>
import {computed} from "vue";
import {useCompany} from "src/composables/company.js";
import {getCssVar} from "quasar";

defineProps(['download'])

const { brand_primary,color_primary } = useCompany()
const primary_brand = brand_primary || getCssVar("primary"), primary_color = color_primary || "#000000"
const style = computed(() => 'background-color: ' + primary_brand + '; color: ' + primary_color + '; border: 1px solid ' + primary_color)
</script>
