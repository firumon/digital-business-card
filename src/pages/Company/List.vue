<template>
  <q-page padding>
    <div class="text-center" v-if="!Companies.length">No Companies</div>
    <div class="row q-col-gutter-sm" v-else>
      <div class="col col-xs-6 col-sm-4 col-md-3 col-lg-3 col-xl-2" v-for="Company in Companies">
        <q-card>
          <q-img :src="Company.logo_url" ratio="1.5" fit="contain" @click="routes.push('company_detail',Company)" class="cursor-pointer">
            <div class="text-subtitle2 absolute-bottom">{{ Company.name }}</div>
          </q-img>
          <q-list v-if="ListMenus.length" separator>
            <q-item clickable v-for="menu in ListMenus" :to="routes.pushRouteObj(menu.name,Company)">
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
import {computed} from "vue";
import {useRoutes} from "src/composables/routes.js";
import {useCompanyStore} from "stores/company.js";

const companyStore = useCompanyStore()

const routes = useRoutes()

const Companies = computed(() => companyStore.Companies)
const ListMenus = computed(() => routes.listMenus.value)
</script>
