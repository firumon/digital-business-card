<template>
  <q-page-sticky position="bottom-left" :offset="[12,12]">
    <q-fab icon="download" direction="right" color="primary" glossy push active-icon="fast_rewind">
      <q-fab-action color="primary" push icon="person_add" label="Add to Contacts" @click="addContact" />
      <q-fab-action color="primary" push icon="download" label="Download" @click="download" />
    </q-fab>
  </q-page-sticky>
</template>

<script setup>
import {generate} from "assets/vCardsJSHelper.js";
import {ref} from "vue";
import {openURL} from "quasar";


const props = defineProps(['individual','company','contacts'])
const vcard = ref('')

function individualName(){
  return String(props.individual.name).replace(/[^\w ]/g, '');
}
function doGenerate(){ vcard.value = generate(props.contacts,props.individual,props.company) }
function addContact(){
  if(!vcard.value) doGenerate();
  openURL("data:text/vcard;charset=utf-8," + encodeURI(vcard.value));
}
function download(){
  if(!vcard.value) doGenerate();
  const blob = new Blob([vcard.value], { type: 'text/vcard' });
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = individualName() + ".vcf";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}
</script>
