<template>
  <div class="text-center bg-primary bg-transparent">
    <q-avatar :size="avatar_size" class="q-mb-sm shadow-10"><img :src="props.profile_photo" alt="profile_photo" /></q-avatar>
    <div class="text-h5 text-bold text-uppercase">{{ props.name }}</div>
    <div class="text-bold">{{ props.designation }}</div>
  </div>
</template>

<script setup>
import {computed} from "vue";
import { useQuasar } from 'quasar'

const $q = useQuasar()
const props = defineProps(['color','layout','profile_photo','name','designation'])

const photo_span = computed(() => parseInt(props.layout.photo_span || 25))
const avatar_size = computed(() => parseInt($q.screen.height * photo_span.value / 100) + 'px')
const style_border = computed(() => '3px solid ' + props.color)
</script>

<style>
.q-avatar div {
  border: v-bind(style_border);
}
</style>
