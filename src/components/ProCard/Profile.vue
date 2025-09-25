<template>
  <div class="text-center">
    <q-avatar :size="avatar_size" class="bg-white">
      <img :src="props.profile_photo" alt="profile_photo" />
    </q-avatar>
  </div>
</template>

<script setup>
import {computed} from "vue";
import { useQuasar } from 'quasar'

const $q = useQuasar()
const props = defineProps(['color','layout','profile_photo','name','designation'])

const photo_span = computed(() => parseInt(props.layout.photo_span || 25))
const avatar_size = computed(() => parseInt($q.screen.height * photo_span.value / 100) + 'px')
const style_border = computed(() => '2px solid ' + props.color)
</script>

<style>
.q-avatar div {
  border: v-bind(style_border);
  width: calc(100% - 5px) !important;
  height: calc(100% - 5px) !important;
  margin: auto;
}
</style>
