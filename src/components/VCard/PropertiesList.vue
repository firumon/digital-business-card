<template>
  <q-list separator>
    <q-item>
      <q-item-section><q-input label="Filter" outlined v-model="filterText" /></q-item-section>
    </q-item>
    <q-item v-for="Property in filteredProperties" clickable v-ripple @click="$emit('tap',Property)">
      <q-item-section>
        <q-item-label>{{ Property.property }} ({{ Property.category }})</q-item-label>
        <q-item-label caption>{{ Property.example }}</q-item-label>
        <q-item-label caption>{{ Property.description }}</q-item-label>
      </q-item-section>
    </q-item>
  </q-list>
</template>

<script setup>
import {computed, ref} from "vue";
import {usePropertyStore} from "stores/property.js";

defineEmits(['tap'])

const filterText = ref(''), propertyStore = usePropertyStore()

const Properties = computed(() => propertyStore.VCardProperties)
const filteredProperties = computed(() => filterText.value ? Properties.value.filter(prop => [prop.property,prop.example,prop.description,prop.category].join(' ').toLowerCase().includes(filterText.value)) : Properties.value)
</script>
