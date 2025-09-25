<template>
  <q-separator v-if="separate !== false" />
  <div class="q-my-md q-px-sm" >
    <q-input :model-value="startCase(param.attr)" borderless readonly disable>
      <template #after v-if="param.description"><HelpTipDescPopup :description="param.description" /></template>
    </q-input>
    <div class="q-mt-sm" v-if="param.image" style="height: 100px">&nbsp;</div>
  </div>
</template>

<script setup>
import {startCase} from "lodash";
import HelpTipDescPopup from "components/HelpTipDescPopup.vue";

defineProps(['separate','param'])
</script>
