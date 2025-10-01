<template>
  <div class="flex justify-between column q-mx-auto" style="width: 60%;">
    <IndividualContact v-for="contact in contacts" :name="contact" :value="propsValue[contact]" />
  </div>
</template>

<script setup>
import IndividualContact from "components/Cards/ProCard/IndividualContact.vue";
import {computed, inject} from "vue";

const propsValue = inject('propsValue')
const all_contacts = ['mobile_number','office_number','email_address','website','whatsapp','instagram','facebook','linkedin','messenger']
const contacts = computed(() => all_contacts.filter(contact => propsValue.value.hasOwnProperty(contact)))
</script>
