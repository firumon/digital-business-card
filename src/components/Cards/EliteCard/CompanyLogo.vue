<template>
  <div class="company-logo q-my-md">&nbsp;</div>
</template>

<script setup>
import {computed} from "vue";
import { useQuasar } from "quasar";
import {useCompany} from "src/composables/company.js";
const { screen } = useQuasar();

const props = defineProps(['logo_span','background_image'])
const { logo } = useCompany()

let logo_span_int = computed(() => parseInt(props.logo_span) || 14)
let display_height = computed(() => parseInt(screen.height * parseInt(logo_span_int.value) / 100) + 'px')
let logo_image = computed(() => 'url("' +logo+ '")')
</script>

<style>
.company-logo {
  background-image: v-bind(logo_image);
  height: v-bind(display_height);
  width: 100%;
  background-position: center;
  background-size: contain;
  background-repeat: no-repeat;
}
</style>
