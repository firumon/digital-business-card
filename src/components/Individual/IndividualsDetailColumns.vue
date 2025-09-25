<template>
  <q-card-section horizontal class="individuals_column" :style="'min-height:'+spanHeight">
    <IndividualsDetailColumnsDetails :style="'width:'+individualWidthSpan+';min-height:'+props.span_height" class="individual_column" :params="props.params" v-for="(individual,code) in props.individuals" :key="'i-'+code" :code="code" :individual="individual" @commit="$emit('commit',{ code,attrValue:$event })" @push="$emit('push',code)" />
    <IndividualsDetailColumnsCreate :style="'width:'+individualWidthSpan+';min-height:'+props.span_height" class="individual_column" :params="props.params" code="NEW" :individual="props.individuals['NEW']" @commit="$emit('commit',{ code:'NEW',attrValue:$event })" @push="$emit('push','NEW')" />
  </q-card-section>
</template>

<script setup>
import {useQuasar} from "quasar";
import {computed} from "vue";
import IndividualsDetailColumnsDetails from "components/Individual/IndividualsDetailColumnsDetails.vue";
import IndividualsDetailColumnsCreate from "components/Individual/IndividualsDetailColumnsCreate.vue";

const { screen } = useQuasar()

defineEmits(['commit','push'])
const individualWidthSpan = computed(() => Math.floor(screen.width * 50 / 100) + 'px')

const props = defineProps(['span_height','params','individuals'])
const spanHeight = computed(() => props.span_height)
</script>

<style>
.individual_column:nth-child(odd) { background-color: #FAFAFA; }
</style>
