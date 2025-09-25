<template>
  <div class="row q-col-gutter-sm">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2" v-for="Company in managerCompanies">
      <q-card flat bordered>
        <q-img :src="Company.logo_url" ratio="1.5" fit="contain" class="cursor-pointer" height="180px">
          <div class="absolute-bottom">
            <div class="text-caption">{{ Company.code }}</div>
            <div class="text-subtitle2">{{ Company.name }}</div>
            <div>{{ Company.base_url }}</div>
          </div>
        </q-img>
        <q-card-actions align="between">
          <q-btn icon="menu_book" label="Details" flat no-caps color="primary" :to="{ name:'company_detail',params:{ id:Company.id } }" />
          <q-btn icon="read_more" label="Individuals" flat no-caps color="primary" :to="{ name:'company_individuals',params:{ company_id:Company.id } }" />
        </q-card-actions>
      </q-card>
    </div>
    <div v-if="!managerCompanies.length" class="col-12 text-center">no companies assigned yet..</div>
  </div>
</template>

<script setup>
import {computed} from "vue";
import {useCompanyStore} from "stores/company.js";
import {filter} from "lodash";

const props = defineProps(['manager_id'])

const companyStore = useCompanyStore()
const managerCompanies = computed(() => filter(companyStore.Companies,({ users }) => users.includes(props.manager_id)))

</script>
