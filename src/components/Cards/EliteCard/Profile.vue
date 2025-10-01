<template>
  <div class="text-center bg-primary bg-transparent">
    <q-avatar :size="avatar_size" class="q-mb-sm shadow-10"><img :src="props.profile_photo" alt="profile_photo" /></q-avatar>
    <div class="text-h5 text-bold text-uppercase">{{ props.individual_name }}</div>
    <div class="text-bold">{{ props.designation }}</div>
  </div>
</template>

<script setup>
import {computed} from "vue";
import {getCssVar, useQuasar} from 'quasar'
import {useCompany} from "src/composables/company.js";

const { screen } = useQuasar(), { color_primary } = useCompany()
const props = defineProps(['profile_photo','photo_span','individual_name','designation'])
const primary_color = color_primary || getCssVar("primary")

const photo_span_int = computed(() => parseInt(props.photo_span || 25))
const avatar_size = computed(() => parseInt(screen.height * photo_span_int.value / 100) + 'px')
const style_border = computed(() => '3px solid ' + primary_color)
</script>

<style>
.q-avatar div {
  border: v-bind(style_border);
}
</style>
