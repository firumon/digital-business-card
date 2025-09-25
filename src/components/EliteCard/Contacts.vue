<template>
  <div class="row q-px-md q-col-gutter-x-xs q-col-gutter-y-sm text-center">
    <div class="col-6" v-for="item in items" :key="item.name"><ContactButton v-bind="item" :style="props.style" /></div>
  </div>
</template>

<script setup>
import {computed} from "vue";
import {filter, get, map} from "lodash";
import ContactButton from "components/EliteCard/ContactButton.vue";

const props = defineProps(['items','contacts','style'])
const contacts = computed(() => props.contacts || ({}))
const items = computed(() => filter(map(props.items,name => get(contacts.value,name,false) ? ({ name,value:contacts.value[name] }) : false)))
</script>
