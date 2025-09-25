<template>
  <q-card-section class="attr_column q-px-none">
    <IndividualsAttributeColumnAttribute :param="{ attr:'name' }" :separate="false" />
    <IndividualsAttributeColumnAttribute :param="{ attr:'designation' }" />
    <IndividualsAttributeColumnAttribute v-for="(param) in props.params" :key="param.id" :param="param" />
    <div style="height: 80px;">&nbsp;</div>
  </q-card-section>
</template>

<script setup>
import IndividualsAttributeColumnAttribute from "components/Individual/IndividualsAttributeColumnAttribute.vue";

const props = defineProps(['params'])
</script>

<style>
.attr_column { z-index: 2; max-width: 40%; border-right-width: 0; box-shadow: 2px 0 8px 0 rgba(0, 0, 0, 0.1) !important; }
</style>
