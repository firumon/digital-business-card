<template>
  <q-page padding>
    <div class="text-center" v-if="!Layouts.length">No layouts</div>
    <div class="row q-col-gutter-sm" v-else>
      <div class="col col-xs-6 col-sm-4 col-md-3 col-lg-3 col-xl-2" v-for="Layout in Layouts">
        <q-card>
          <q-img :src="Layout.image" ratio="0.5" fit="contain" @click="layoutDetail(Layout)">
            <div class="text-subtitle2 absolute-bottom">{{ Layout.name }}</div>
          </q-img>
          <q-list v-if="ListMenus.length" separator>
            <q-item clickable v-for="menu in ListMenus" :to="routes.pushRouteObj(menu.name,Layout)">
              <q-item-section side><q-icon color="secondary" :name="menu.icon" /></q-item-section>
              <q-item-section><q-item-label>{{ menu.label }}</q-item-label></q-item-section>
            </q-item>
          </q-list>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script setup>
import {computed, ref} from "vue";
import {useLayoutStore} from "stores/layout.js";
import {useRoutes} from "src/composables/routes.js";

const layoutStore = useLayoutStore()

const routes = useRoutes()

const Layouts = computed(() => layoutStore.Layouts)
const ListMenus = computed(() => routes.listMenus.value)

function layoutDetail({ id }){ routes.push('layout_detail',{ id }) }
</script>
