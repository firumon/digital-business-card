<template>
  <q-page padding class="q-gutter-sm">
    <q-card v-if="Properties">
      <q-card-section class="bg-grey-2 text-bold">Properties</q-card-section>
      <q-card-section>
        <q-list separator>
          <q-item v-for="Property in Properties">
            <q-item-section side>{{ VCardProperties[Property.v_card_property_id].property }}</q-item-section>
            <q-item-section>
              <q-item-label>{{ Property.name }}</q-item-label>
              <q-item-label caption>{{ Property.description }}</q-item-label>
            </q-item-section>
            <q-item-section side>{{ JSON.stringify(Property.params).slice(1,-1) }}</q-item-section>
            <q-item-section side><q-btn icon="delete" color="negative" flat dense @click="remove(Property)" /></q-item-section>
          </q-item>
        </q-list>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import {computed} from "vue";
import {usePropertyStore} from "stores/property.js";

const propertyStore = usePropertyStore()
const Properties = computed(() => propertyStore.Properties)
const VCardProperties = computed(() => propertyStore.VCardPropertiesById)

function remove({ id }){
  propertyStore.deleteProperty(id)
}
</script>
