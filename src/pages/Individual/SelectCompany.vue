<template>
  <q-page padding>
    <div class="row q-col-gutter-xs">
      <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" v-for="Company in companies">
        <q-card class="cursor-pointer" @click="routes.push('company_individuals',Company)">
          <q-img :src="Company.logo_url" style="height: 15vh;" fit="contain" class="cursor-pointer">
            <div class="text-subtitle2 absolute-bottom">{{ Company.name }}</div>
          </q-img>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script setup>
import {computed} from "vue";
import {useCompanyStore} from "stores/company.js";
import {useRoutes} from "src/composables/routes.js";

const companyStore = useCompanyStore(), routes = useRoutes()
const companies = computed(() => companyStore.Companies)
</script>
