<template>
  <div class="row q-col-gutter-sm">
    <div class="col-12 flex items-center q-py-md q-pl-md"><div class="text-bold text-subtitle1">Select Manager</div><q-space /><q-btn icon="close" v-if="props.modelValue" color="red" flat @click="emits('update:modelValue',props.modelValue)"/> </div>
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 col-xl-1" v-for="Manager in Managers">
      <q-card flat bordered @click="emits('update:modelValue',Manager.id)" v-ripple>
        <q-card-section class="bg-grey-2">
          <div class="text-subtitle1 text-bold">{{ Manager.name }}</div>
          <div class="text-body2">{{ Manager.email }}</div>
        </q-card-section>
        <q-separator />
        <q-card-actions align="right">
          <q-icon name="forward" color="primary" size="sm" />
        </q-card-actions>
      </q-card>
    </div>
  </div>
</template>

<script setup>
import {useUserStore} from "stores/user.js";
import {computed} from "vue";
import {filter} from "lodash";

const props = defineProps(['modelValue'])
const emits = defineEmits(['update:modelValue'])

const userStore = useUserStore()
const Managers = computed(() => filter(userStore.Users,['role','Manager']))
</script>
