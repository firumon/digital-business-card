<template>
  <div class="q-px-xl">
    <q-btn label="Save me as a Contact" :style="style" class="full-width glossy" icon="download" />
  </div>
</template>

<script setup>
import {computed} from "vue";

const props = defineProps(['color','brand'])
const style = computed(() => 'background-color: ' + props.brand + '; color: ' + props.color + '; border: 1px solid ' + props.color)
</script>
