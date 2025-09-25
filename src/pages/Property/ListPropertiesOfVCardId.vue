<template>
  <q-card v-if="selectedProperties.length">
    <q-card-section class="text-bold bg-grey-2">Current Properties of Selected VCard Property: {{ name }}</q-card-section>
    <q-card-section>
      <q-list>
        <q-item v-for="selectedProperty in selectedProperties">
          <q-item-section>
            <q-item-label>{{ selectedProperty.name }}</q-item-label>
            <q-item-label caption>{{ selectedProperty.description }}</q-item-label>
          </q-item-section>
          <q-item-section>
            <q-item-label caption>Default Value: {{ selectedProperty.value }}</q-item-label>
            <q-item-label caption>Example: {{ selectedProperty.example }}</q-item-label>
          </q-item-section>
          <q-item-section side>{{ JSON.stringify(selectedProperty.params).slice(1,-1) }}</q-item-section>
          <q-item-section side><q-btn icon="delete" color="negative" flat dense @click="remove(selectedProperty)" /></q-item-section>
        </q-item>
      </q-list>
    </q-card-section>
  </q-card>
</template>

<script setup>
import {usePropertyStore} from "stores/property.js";
import {computed} from "vue";

const props = defineProps(['id','name'])
const propertyStore = usePropertyStore()

const properties = computed(() => propertyStore.PropertiesByVCardPropertyId)
const selectedProperties = computed(() => props.id && properties.value.hasOwnProperty(props.id) ? properties.value[props.id] : [])

function remove({ id }){ propertyStore.deleteProperty(id) }

</script>
