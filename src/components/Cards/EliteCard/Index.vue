<template>
  <div class="flex justify-between content-center column EliteCard">
    <CompanyLogo v-bind="propsValue" />
    <Profile v-bind="propsValue" :individual_name="individual_name" />
    <Download :download="download" />
    <Contacts v-bind="propsValue" :propsValue="propsValue" :style="invert_style" />
    <CompanyButtons :color="color_primary" />
  </div>
</template>

<script setup>
import CompanyLogo from "components/Cards/EliteCard/CompanyLogo.vue";
import Profile from "components/Cards/EliteCard/Profile.vue";
import Download from "components/Cards/EliteCard/Download.vue";
import Contacts from "components/Cards/EliteCard/Contacts.vue";
import { colors } from "quasar";
import {computed} from "vue";
import CompanyButtons from "components/Cards/EliteCard/CompanyButtons.vue";
import {useColor} from "src/composables/color.js";

const { brand_primary,color_primary } = useColor(), { hexToRgb } = colors
const props = defineProps(['propsValue','background_image','individual_name','download'])

const rgba = computed(() => Object.values(hexToRgb(brand_primary.value)).join(',') + ',0.60')
const invert_style = computed(() => 'background-color: ' + color_primary.value + '; color: ' + brand_primary.value)
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
