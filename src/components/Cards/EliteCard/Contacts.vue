<template>
  <div class="row q-px-md q-col-gutter-x-xs q-col-gutter-y-sm text-center">
    <div class="col-6" v-for="item in items" :key="item">
      <ContactButton :name="item" :value="propsValue[item]" :style="props.style" />
    </div>
  </div>
</template>

<script setup>
import ContactButton from "components/Cards/EliteCard/ContactButton.vue";

const props = defineProps(['propsValue','style'])
const items = ['mobile_number','email','whatsapp','messenger']
</script>
