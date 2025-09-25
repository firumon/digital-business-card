<template>
  <q-page padding>
    <InnerLoading v-if="loading" />
    <div class="row q-col-gutter-sm" v-else>
      <div class="col col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xl-2" v-for="layout in layouts">
        <q-card>
          <q-img src="https://cdn.quasar.dev/img/parallax2.jpg">
            <div class="text-subtitle2 absolute-bottom">{{ layout.name }}</div>
          </q-img>
          <q-list>
            <q-item clickable v-for="action in actions" :to="action.path.replace('id',layout.id)">
              <q-item-section avatar><q-icon color="primary" :name="action.icon" /></q-item-section>
              <q-item-section><q-item-label>{{ action.label }}</q-item-label></q-item-section>
            </q-item>
          </q-list>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script setup>
import {ref} from "vue";
import {orderBy} from "lodash";
import {api} from "boot/axios.js";

import InnerLoading from "components/InnerLoading.vue";
const loading = ref(false)
const layouts = ref([])

const actions = [
  { icon:'filter_list',label:'Properties',path:'layout/id/properties' },
]

api('layouts').then(listLayouts)

function listLayouts(lays){
  layouts.value.splice(0,layouts.value.length)
  orderBy(lays,'id','desc').map(lay => layouts.value.push(lay))
  loading.value = false;
}
</script>
