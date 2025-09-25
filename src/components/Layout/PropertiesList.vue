<template>
  <q-card>
    <q-card-section class="bg-grey-2 text-bold">Properties</q-card-section>
    <q-list v-if="Properties.length">
      <q-item v-for="Property in Properties">
        <q-item-section>
          <q-item-label>{{ Property.name }}</q-item-label>
          <q-item-label caption>Type: {{ Property.type }}</q-item-label>
          <q-item-label caption>Property: {{ Property.property_name }}</q-item-label>
        </q-item-section>
        <q-item-section>
          <q-item-label><q-icon :name="Property.mandatory ? 'check' : 'close'" /> Mandatory</q-item-label>
          <q-item-label><q-icon :name="Property.image ? 'check' : 'close'" /> Image</q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
    <q-item-label v-else header class="text-center">No properties defined yet..</q-item-label>
  </q-card>
</template>

<script setup>
import {computed} from "vue";
import {useLayoutStore} from "stores/layout.js";

const layoutStore = useLayoutStore()

const props = defineProps(['layout_id'])
const Layout = computed(() => layoutStore.LayoutsById ?. [props.layout_id])
const Properties = computed(() => Layout.value ? Layout.value.properties : [])
</script>
