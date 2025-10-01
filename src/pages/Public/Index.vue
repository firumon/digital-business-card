<template>
  <q-page>
    <component
      v-bind="propValue"
      :is="layoutComponent"
      :propsValue="propValue"
      :individual_name="individual_name"
      :company_name="company_name"
      :download="vCardDownload"
    />
  </q-page>
</template>

<script setup>
import {useLayout} from "src/composables/layout.js";
import {computed, defineAsyncComponent} from "vue";
import {useProperty} from "src/composables/property.js";
import {useCompany} from "src/composables/company.js";
import {useIndividual} from "src/composables/individual.js";
import vCardsJs from "assets/vCardsJs.js";

const { name,properties_vcard } = useLayout(), property = useProperty(), company = useCompany(), individual = useIndividual();

const layoutComponent = computed(() => defineAsyncComponent(() => import(`components/Cards/${name}/Index.vue`)))

const cProps = computed(() => company.properties.value)
const iProps = computed(() => individual.properties.value)
const propValue = computed(() => property.propertyValue(cProps.value,iProps.value))

const individual_name = computed(() => individual.full_name.value)
const company_name = computed(() => company.company_name.value)

function vCardDownload(){
  const vCard = new vCardsJs(properties_vcard.value,propValue.value,individual_name.value,company_name.value)
  vCard.download();
}
</script>
