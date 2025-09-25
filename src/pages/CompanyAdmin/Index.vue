<template>
  <q-page :styleFn="pageHeight">
    <q-card flat square>
      <q-card-section horizontal>
        <IndividualsAttributeColumn :params="params" />
        <q-scroll-area class="col-grow scroll_area">
          <IndividualsDetailColumns :span_height="spanHeight" :params="params" :individuals="individuals" @commit="commit" @push="push" />
        </q-scroll-area>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import {provide, ref} from "vue";
import {filter, map} from "lodash";
import IndividualsDetailColumns from "components/Individual/IndividualsDetailColumns.vue";
import IndividualsAttributeColumn from "components/Individual/IndividualsAttributeColumn.vue";
import {api} from "boot/axios.js";


const individuals = ref(__INDIVIDUALS); individuals.value['NEW'] = {}
const params = ref(filter(__COMPANY.layout.master.attrs,'individual'))

const spanHeight = ref('100px'), updates = ref([])
function pageHeight(offset,screen_height){ spanHeight.value = (screen_height - offset + 80) + 'px'; }

function commit({ code,attrValue }){ map(attrValue,(value,attr) => individuals.value[code][attr] = value); addToUpdates(code) }
function push(code){
  api('individual',{ code,individual:individuals.value[code] }).then(function(data){
    setIndividual(data.code,data)
    removeFromUpdates(code); individuals.value.NEW = {}
  })
}
function addToUpdates(code){ if(updates.value.indexOf(code) === -1) updates.value.push(code); }
function removeFromUpdates(code){
  let idx = updates.value.indexOf(code);
  if(idx > -1) updates.value.splice(idx,1);
}
function setIndividual(code,data){
  if(!individuals.value.hasOwnProperty(code)) individuals.value[code] = {}
  map(data,(value,attr) => individuals.value[code][attr] = value)
}
provide('updates',updates)
</script>

<style>
.scroll_area { min-height: v-bind(spanHeight); padding: 0 3px; }
</style>
