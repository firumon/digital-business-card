<template>
  <q-select :options="layout_options" v-model="selected" outlined emit-value map-options />
</template>

<script setup>
import {computed} from "vue";
import {useLayoutStore} from "stores/layout.js";

const props = defineProps(['modelValue'])
const emits = defineEmits(['update:modelValue'])

const layoutStore = useLayoutStore();
const Layouts = computed(() => layoutStore.Layouts);
const layout_options = computed(() => Layouts.value.map(layout => ({ label:layout.name,value:layout.id })))

const selected = computed({
  get:() => props.modelValue,
  set:(id) => emits('update:modelValue',id)
})
</script>
