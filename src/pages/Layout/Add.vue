<template>
  <q-page padding class="q-gutter-sm">
    <q-card>
      <q-card-section class="bg-grey-2 text-bold">Add New Layout</q-card-section>
      <q-card-section class="q-gutter-y-sm">
        <div class="row q-col-gutter-x-sm">
          <div class="col-5"><q-img :src="layout.image" class="full-width" v-if="layout.image" /></div>
          <div class="col-7 q-gutter-y-sm">
            <q-input v-model="layout.image" label="Layout Preview - Image URL" outlined />
            <q-input v-model="layout.name" label="Layout Name (No Space)" outlined />
            <q-input v-model="layout.description" label="Detailed Description" outlined type="textarea" />
            <q-input v-model="layout.font_primary" label="Primary Font - (Google Font Name)" outlined />
            <q-input v-model="layout.font_secondary" label="Secondary Font - (Google Font Name)" outlined />
            <q-input v-model="layout.brand_primary" outlined label="Primary Brand Color (Hexa Value)" />
            <q-input v-model="layout.brand_secondary" outlined label="Secondary Brand Color (Hexa Value)" />
            <q-input v-model="layout.color_primary" outlined label="Primary Color (Hexa Value)" />
            <q-input v-model="layout.color_secondary" outlined label="Secondary Color (Hexa Value)" />
          </div>
        </div>
      </q-card-section>
      <q-card-actions align="right" class="bg-grey-1">
        <q-btn label="Save Layout" color="primary" @click="saveLayout" />
      </q-card-actions>
    </q-card>
    <InnerLoading :loading="loading" />
  </q-page>
</template>

<script setup>
import {reactive, ref} from "vue";
import InnerLoading from "components/InnerLoading.vue";
import {useLayoutStore} from "stores/layout.js";
import {map} from "lodash";

const loading = ref(false)
const layout = reactive({ image:null,name:null,description:null,font_primary:null,font_secondary:null,brand_primary:null,brand_secondary:null,color_primary:null,color_secondary:null })

const layoutStore = useLayoutStore()
function saveLayout(){
  loading.value = true;
  layoutStore.addNewLayout(layout).then(layoutSaveComplete);
}
function layoutSaveComplete(){
  map(layout,(val,lay) => layout[lay] = null)
  loading.value = false;
}
</script>
