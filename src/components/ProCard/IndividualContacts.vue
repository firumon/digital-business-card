<template>
  <div class="flex justify-between column q-mx-auto" style="width: 60%;">
    <IndividualContact v-for="contact in contacts" :contact="contact" :value="individual[contact]" />
  </div>
</template>

<script setup>
import IndividualContact from "components/ProCard/IndividualContact.vue";

const props = defineProps(['individual','contacts'])
</script>
