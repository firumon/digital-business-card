<template>
  <div class="q-px-xl">
    <q-btn label="Save me as a Contact" :style="style" class="full-width glossy" icon="download" @click="download" />
  </div>
</template>

<script setup>
import {computed} from "vue";
import {useColor} from "src/composables/color.js";

defineProps(['download'])

const { brand_primary,color_primary } = useColor()
const style = computed(() => 'background-color: ' + brand_primary.value + '; color: ' + color_primary.value + '; border: 1px solid ' + color_primary.value)
</script>
