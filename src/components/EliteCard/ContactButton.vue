<template>
  <q-btn :label="label" class="full-width contact_button" no-caps @click="() => openURL(url)" />
</template>

<script setup>
import {computed} from "vue";
import {openURL} from "quasar";

const props = defineProps(['name','value'])

const rule = {
  mobile_number: { label:props.value,action:'tel:'+props.value },
  office_number: { label:props.value,action:'tel:'+props.value },
  email_address: { label:props.value,action:'mailto:'+props.value },
  website: { label:props.value,action:props.value },
  whatsapp: { label:'WhatsApp',action:'https://wa.me/' + props.value + '?text=Hello' },
  instagram: { label:'Instagram',action: ['http','inst'].includes(props.value.slice(0,4)) ? (props.value.slice(0,4) === 'inst' ? 'https://'+props.value : (props.value.slice(0,5) === 'https' ? props.value : 'https' + props.value.slice(4)) ) : 'https://instagram.com/' + props.value },
  facebook: { label:'Facebook',action: ['http','face'].includes(props.value.slice(0,4)) ? (props.value.slice(0,4) === 'face' ? 'https://'+props.value : (props.value.slice(0,5) === 'https' ? props.value : 'https' + props.value.slice(4)) ) : 'https://www.facebook.com/' + props.value },
  messenger: { label:'Messenger',action:'https://m.me/' + props.value + '?text=Hello' },
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
