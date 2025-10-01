<template>
  <div class="flex justify-between content-center column EliteCard">
    <CompanyLogo v-bind="propsValue" />
    <Profile v-bind="propsValue" :individual_name="individual_name" />
    <Download :download="download" />
    <Contacts v-bind="propsValue" :propsValue="propsValue" :style="invert_style" />
    <CompanyButtons :color="primary_color" />
  </div>
</template>

<script setup>
import CompanyLogo from "components/Cards/EliteCard/CompanyLogo.vue";
import Profile from "components/Cards/EliteCard/Profile.vue";
import Download from "components/Cards/EliteCard/Download.vue";
import Contacts from "components/Cards/EliteCard/Contacts.vue";
import {useCompany} from "src/composables/company.js";
import { getCssVar,colors } from "quasar";
import {computed} from "vue";
import CompanyButtons from "components/Cards/EliteCard/CompanyButtons.vue";

const { brand_primary,color_primary } = useCompany(), { hexToRgb } = colors
const props = defineProps(['propsValue','background_image','individual_name','download'])
const primary_brand = brand_primary || getCssVar("primary")
const primary_color = color_primary || "#000000"

const rgba = computed(() => Object.values(hexToRgb(primary_brand)).join(',') + ',0.60')
const invert_style = computed(() => 'background-color: ' + primary_color + '; color: ' + primary_brand)
const background_image = computed(() => 'linear-gradient(rgba('+rgba.value+'), rgba('+rgba.value+')), url("'+props.background_image+'")')
</script>

<style>
.EliteCard {
  min-height: 100vh;
  background-image: v-bind(background_image);
  background-position: top center;
  background-size: cover;
  background-repeat: no-repeat;
}
</style>
