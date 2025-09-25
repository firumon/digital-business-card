<template>
  <div class="text-center q-py-md q-px-xl q-gutter-y-sm" v-if="enabled">
    <CompanyButton v-for="action in actions" v-bind="action" :color="color" />
  </div>
</template>

<script setup>
import CompanyButton from "components/EliteCard/CompanyButton.vue";
import {computed} from "vue";
import {get} from "lodash";

defineProps(['color'])

const actions = computed(() => get(__DATA,['layout','actions']))
const enabled = computed(() => actions.value.length > 0)
</script>
