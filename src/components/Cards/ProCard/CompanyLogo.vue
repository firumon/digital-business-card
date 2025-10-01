<template>
  <div class="company-logo q-my-md q-mx-auto" style="width: 60%">&nbsp;</div>
</template>

<script setup>
import {computed, inject} from "vue";
import { useQuasar } from "quasar";
import {useCompany} from "src/composables/company.js";


const { screen } = useQuasar();
const { logo } = useCompany()
const propsValue = inject('propsValue')

let logo_span = computed(() => parseInt(propsValue.value.logo_span || 14))
let display_height = computed(() => parseInt(screen.height * logo_span.value / 100) + 'px')
let background_image = computed(() => 'url("' +logo+ '")')
</script>

<style>
.company-logo {
  background-image: v-bind(background_image);
  height: v-bind(display_height);
  width: 100%;
  background-position: center;
  background-size: contain;
  background-repeat: no-repeat;
}
</style>
