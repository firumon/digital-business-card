<template>
  <q-page class="flex justify-between content-center column">
    <CompanyLogo />
    <Profile v-bind="individual" :layout="layout" :color="color_primary" />
    <Download :color="color_primary" :brand="brand_primary" />
    <Contacts :items="layout.contacts" :contacts="individual" :style="invert_style" />
    <CompanyButtons :color="color_primary" />
  </q-page>
</template>

<script setup>
import CompanyLogo from "components/EliteCard/CompanyLogo.vue";
import Profile from "components/EliteCard/Profile.vue";
import Download from "components/EliteCard/Download.vue";
import CompanyButtons from "components/EliteCard/CompanyButtons.vue";

import {computed} from "vue";
import { getCssVar,colors } from "quasar";

import {get} from "lodash";
import Contacts from "components/EliteCard/Contacts.vue";
import {useDataStore} from "stores/data.js";
const { hexToRgb } = colors


const props = defineProps(['id'])
const individual = computed(() => get(__DATA,'individual'))
const layout = computed(() => get(__DATA,['layout']))
const theme = computed(() => get(__DATA,['theme']))

const brand_primary = computed(() => getCssVar('primary'))
const color_primary = computed(() => theme.value.color.primary)
const rgba = computed(() => Object.values(hexToRgb(brand_primary.value)).join(',') + ',0.60')
const background_profile = computed(() => 'linear-gradient(rgba('+rgba.value+'), rgba('+rgba.value+')), url("'+individual.value.background_profile+'")')

const invert_style = computed(() => 'background-color: ' + color_primary.value + '; color: ' + brand_primary.value)

const data = useDataStore()
</script>

<style>
.q-page {
  background-image: v-bind(background_profile);
  background-position: top center;
  background-size: cover;
  background-repeat: no-repeat;
}
</style>
