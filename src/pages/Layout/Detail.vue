<template>
  <q-page padding class="q-gutter-y-sm">
    <div class="q-gutter-y-sm">
      <q-input v-model="updates.image" outlined label="Preview Image URL" />
      <q-input v-model="updates.name" outlined label="Layout Name (no space)" />
      <q-input v-model="updates.description" outlined label="Detail Description" type="textarea" />
      <q-input v-model="updates.font_primary" outlined label="Primary Font - Google Font Name" />
      <q-input v-model="updates.font_secondary" outlined label="Secondary Font - Google Font Name" />
      <q-btn class="full-width" color="primary" padding="md" size="md" label="Update Layout Details" @click="updateLayout" />
    </div>
    <UsersList :layout_id="id" />
    <PropertiesList :layout_id="id" />
    <InnerLoading :loading="loading" />
  </q-page>
</template>

<script setup>
import InnerLoading from "components/InnerLoading.vue";
import UsersList from "components/Layout/UsersList.vue";
import {useLayoutStore} from "stores/layout.js";
import {computed, onMounted, reactive, ref} from "vue";
import {map} from "lodash";
import PropertiesList from "components/Layout/PropertiesList.vue";
import {useTitle} from "src/composables/title.js";

const layoutStore = useLayoutStore()
const loading = ref(false)
const props = defineProps(['id'])

const updates = reactive({ image:null,name:null,description:null,font_primary:null,font_secondary:null })
const Layout = computed(() => layoutStore.LayoutsById[props.id])

onMounted(function (){ map(updates,(val,key) => updates[key] = Layout.value ?. [key] || null) })

function updateLayout(){
  loading.value = true;
  layoutStore.updateLayout(props.id,updates).then(() => loading.value = false)
}
useTitle(Layout)
</script>
