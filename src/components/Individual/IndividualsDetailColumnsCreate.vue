<template>
  <q-card-section class="q-px-none">
    <IndividualsDetailColumnsDetailsDetail :modelValue="individual['name']" @update:modelValue="$emit('commit',{ name:$event })" :separate="false" :image="false" />
    <IndividualsDetailColumnsDetailsDetail :modelValue="individual['designation']" @update:modelValue="$emit('commit',{ designation:$event })" :image="false" />
    <IndividualsDetailColumnsDetailsDetail :modelValue="individual[param.attr]" @update:modelValue="$emit('commit',{ [param.attr]:$event })" v-for="param in params" :key="'EP-'+individual.code+'/'+param.id" :image="param.image" />
    <div style="height: 80px" class="q-px-xl" v-if="updates.indexOf(code) > -1"><q-btn color="primary" label="Save" class="full-width" @click="clicked = true; $emit('push')" :loading="loading" /></div>
    <q-inner-loading :showing="loading" class="absolute-center full-width"><q-spinner-facebook size="xl" /></q-inner-loading>
  </q-card-section>
</template>

<script setup>
import IndividualsDetailColumnsDetailsDetail from "components/Individual/IndividualsDetailColumnsDetailsDetail.vue";
import {computed, inject, ref, watch} from "vue";

const props = defineProps(['params','individual','code']), emits = defineEmits(['commit','push'])

const updates = inject('updates'), clicked = ref(false)
const loading = computed(() => clicked.value && updates.value.indexOf(props.code) > -1)
watch(updates,function(updVal){
  if(updVal.indexOf(props.code) !== -1 && clicked.value) clicked.value = false
},{ immediate:true,deep:true })
</script>
