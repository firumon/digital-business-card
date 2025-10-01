<template>
  <q-card class="flex column justify-between" style="height: 100vh">
    <TopCurve />
    <CompanyLogo />
    <Profile />
    <NameDesignation :name="individual_name" />
    <IndividualContacts />
    <BottomCurve />
    <q-page-sticky position="bottom-left" :offset="[12,12]">
      <q-fab icon="download" direction="right" color="primary" glossy push active-icon="fast_rewind">
        <q-fab-action color="primary" push icon="person_add" label="Add to Contacts" @click="save" />
        <q-fab-action color="primary" push icon="download" label="Download" @click="download" />
      </q-fab>
    </q-page-sticky>
  </q-card>
</template>

<script setup>
import TopCurve from "components/Cards/ProCard/TopCurve.vue";
import CompanyLogo from "components/Cards/ProCard/CompanyLogo.vue";
import Profile from "components/Cards/ProCard/Profile.vue";
import NameDesignation from "components/Cards/ProCard/NameDesignation.vue";
import IndividualContacts from "components/Cards/ProCard/IndividualContacts.vue";
import BottomCurve from "components/Cards/ProCard/BottomCurve.vue";

defineProps(['individual_name','download','save'])
</script>

<style>
</style>
