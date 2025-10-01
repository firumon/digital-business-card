<template>
  <div class="text-center">
    <q-avatar :size="avatar_size" class="bg-white">
      <img :src="propsValue.profile_photo" alt="profile_photo" />
    </q-avatar>
  </div>
</template>

<script setup>
import {computed, inject} from "vue";
import { useQuasar } from 'quasar'
import {useColor} from "src/composables/color.js";

const { screen } = useQuasar(), { brand_primary } = useColor()

const propsValue = inject('propsValue')

const photo_span = computed(() => parseInt(propsValue.photo_span || 25))
const avatar_size = computed(() => parseInt(screen.height * photo_span.value / 100) + 'px')
const style_border = computed(() => '2px solid ' + brand_primary.value)
</script>

<style>
.q-avatar div {
  border: v-bind(style_border);
  width: calc(100% - 5px) !important;
  height: calc(100% - 5px) !important;
  margin: auto;
}
</style>
