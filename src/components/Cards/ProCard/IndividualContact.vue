<template>
  <q-chip size="md" class="bg-white q-px-none bg-transparent shadow-0 text-grey-9 text-bold" square clickable @click="openURL(IconLabelAction.action)" v-if="IconLabelAction">
    <q-avatar v-if="IconLabelAction.image" color="primary" rounded style="margin-right: 15px !important;">
      <q-img :src="IconLabelAction.image" height="15" width="15" />
    </q-avatar>
    <q-avatar v-else :icon="IconLabelAction.icon" color="primary" rounded style="margin-right: 15px !important;" />
    {{ IconLabelAction.label }}
  </q-chip>
</template>

<script setup>
import {openURL} from "quasar";
import {computed} from "vue";
import * as ImageUrl from "assets/image_uri.js";

const props = defineProps(['name','value'])

const IconLabelAction = computed(function(){
  if(!props.value) return null;
  const rule = {
    mobile_number: { icon:'phonelink_ring',label:props.value,action:'tel:'+props.value },
    office_number: { icon:'phone_in_talk',label:props.value,action:'tel:'+props.value },
    email_address: { icon:'alternate_email',label:props.value,action:'mailto:'+props.value },
    website: { icon:'link',label:props.value,action:props.value },
    whatsapp: { image:ImageUrl.whatsapp, label:'WhatsApp',action:'https://wa.me/' + props.value + '?text=Hello' },
    instagram: { image:ImageUrl.instagram,label:instagramLabel(props.value),action: props.value },
    facebook: { image:ImageUrl.facebook,label:'Facebook',action: props.value },
    linkedin: { image:ImageUrl.linkedin,label:'Linkedin',action: props.value },
    messenger: { image:ImageUrl.messenger,label:'Messenger',action:props.value + '?text=Hello' },
  }
  return rule[props.name];
})

function instagramLabel(url){
  return '@' + String(url).replace(/\/$/,"").split("/").pop()
}
</script>
