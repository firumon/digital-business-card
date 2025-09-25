<template>
  <q-page padding class="q-gutter-y-xs">
    <ChooseLayoutSelect v-model="selected" v-if="!props.layout_id" />
    <q-card>
      <q-card-section class="bg-grey-2 text-bold flex items-center">Layout Properties<q-space /><q-btn v-if="layoutId" icon="add" round dense color="green" @click="createMode = true" /></q-card-section>
      <q-list separator>
        <q-item v-for="(property,idx) in LayoutProperties" clickable @click="editProp(property)">
          <q-item-section side>{{ idx+1 }}</q-item-section>
          <q-item-section>
            <q-item-label>{{ property.name }}</q-item-label>
            <q-item-label caption>{{ property.type }}<span v-if="property.type === 'vcard'"> - {{ property.property_name }}</span> </q-item-label>
          </q-item-section>
          <q-item-section v-if="property.params">
            <q-item-label caption v-for="(val,param) in property.params">{{ param }}: {{ val }}</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-item-label caption>Image: <q-icon :name="property.image ? 'check' : 'close'" /></q-item-label>
            <q-item-label caption>Mandatory: <q-icon :name="property.mandatory ? 'check' : 'close'" /></q-item-label>
          </q-item-section>

        </q-item>
      </q-list>
    </q-card>
    <q-dialog v-model="createMode"><AddProperty :layout_id="layoutId" /></q-dialog>
    <q-dialog v-model="updateMode"><EditProperty :layout_id="layoutId" :name="updateProp" @close="updateProp = null" /></q-dialog>
  </q-page>
</template>

<script setup>
import ChooseLayoutSelect from "components/Layout/ChooseLayoutSelect.vue";
import AddProperty from "components/Layout/AddProperty.vue";
import EditProperty from "components/Layout/EditProperty.vue";
import {useLayoutStore} from "stores/layout.js";
import {computed, ref} from "vue";

const layoutStore = useLayoutStore()

const props = defineProps(['layout_id'])
const selected = ref(props.layout_id)
const layoutId = computed(() => selected.value || props.layout_id)
const Layout = computed(() => layoutId.value ? layoutStore.LayoutsById[layoutId.value] : null)
const LayoutProperties = computed(() => Layout.value ? Layout.value.properties : [])

const createMode = ref(false), updateProp = ref(null)
const updateMode = computed({
  get:() => updateProp.value !== null,
  set:(name) => updateProp.value = name || null
})
function editProp({ name }){ updateProp.value = name }
</script>
