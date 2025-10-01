<template>
  <q-btn :label="label" class="full-width contact_button" no-caps @click="() => openURL(url)" />
</template>

<script setup>
import {computed} from "vue";
import {openURL} from "quasar";

const props = defineProps(['name','value'])
const rule = {
  mobile_number: { label:props.value,action:'tel:'+props.value },
  email: { label:props.value,action:'mailto:'+props.value },
  whatsapp: { label:'WhatsApp',action:'https://wa.me/' + props.value + '?text=Hello' },
  messenger: { label:'Messenger',action:'https://m.me/' + String(props.value).split("/").pop() + '?text=Hello' },
}
const label = computed(() => rule[props.name].label)
const url = computed(() => rule[props.name].action)
</script>

<!--
<style>
.contact_button {
  background-color: #21BA45;
  color: #F2C037;
}
</style>
-->
