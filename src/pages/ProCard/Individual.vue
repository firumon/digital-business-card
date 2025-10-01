<template>
  <q-page class="flex justify-between content-center column" style="overflow: hidden">
    <TopCurve />
    <CompanyLogo />
    <Profile v-bind="individual" :layout="layout" :color="brand_primary" />
    <NameDesignation v-bind="individual" />
    <IndividualContacts :individual="individual" :contacts="contacts" />
    <BottomCurve />
    <StickyDownloadButton :individual="individual" :company="company" :contacts="contacts" />
  </q-page>
</template>

<script setup>
import TopCurve from "components/Cards/ProCard/TopCurve.vue";
import BottomCurve from "components/ProCard/BottomCurve.vue";
import CompanyLogo from "components/ProCard/CompanyLogo.vue";
import Profile from "components/ProCard/Profile.vue";
import NameDesignation from "components/ProCard/NameDesignation.vue";
import IndividualContacts from "components/ProCard/IndividualContacts.vue";
import StickyDownloadButton from "components/ProCard/StickyDownloadButton.vue";

import {computed} from "vue";
import { getCssVar } from "quasar";
import {useDataStore} from "stores/data.js";
const data = useDataStore()

const props = defineProps(['id'])
const company = computed(() => data.company);
const layout = computed(() => data.layout.params);
const contacts = computed(() => data.layout.contacts);
const individual = computed(() => data.individual)

const brand_primary = computed(() => getCssVar('primary'))
</script>
