<template>
  <q-item-label header class="bg-grey-3">Actions</q-item-label>
  <q-item v-for="(action,idx) in actions" :key="'act-'+action.id">
    <q-item-section><q-input outlined v-model="actions[idx].label" @update:modelValue="updateAction('label',action.id,$event)" /></q-item-section>
    <q-item-section side><q-select outlined v-model="actions[idx].type" @update:modelValue="updateAction('type',action.id,$event)" :options="types" /></q-item-section>
    <q-item-section side v-if="types.slice(-2).includes(actions[idx].type)"><q-input outlined v-model="actions[idx].extra" @update:modelValue="updateAction('extra',action.id,$event)" /></q-item-section>
    <q-item-section side><q-btn icon="delete" flat dense padding="none" round color="negative" @click="deleteAction(action.id)" /></q-item-section>
  </q-item>
  <q-item>
    <q-item-section><q-input outlined v-model="create.label" label="Label" /></q-item-section>
    <q-item-section side><q-select outlined v-model="create.type" label="Type" :options="types" /></q-item-section>
    <q-item-section side v-if="types.slice(-2).includes(create.type)"><q-input outlined v-model="create.extra" /></q-item-section>
    <q-item-section side><q-btn icon="forward" flat dense padding="none" round color="positive" @click="createAction()" /></q-item-section>
  </q-item>
  <q-inner-loading :showing="loading"><q-spinner-facebook size="xl" /></q-inner-loading>
</template>

<script setup>
import {reactive, ref} from "vue";
import {debounce} from "quasar";
import {api} from "boot/axios.js";
import {map} from "lodash";

const types = [null,'Home','Next Individual','Previous Individual','Individual','Url']
const actions = ref(__COMPANY.actions)
let loading = ref(false), tmeOut = null;
const create = reactive({ label:'',type:'',extra:'' })

function doPost(method,params){
  loading.value = true; tmeOut = setTimeout(() => loading.value = false,5000)
  api('setting', { setting:'ACT',method,...params }).then(postSuccess)
}
function postSuccess(data){ loading.value = false; clearTimeout(tmeOut); __COMPANY.actions = data; actions.value = data; map(create,(val,key) => create[key] = '') }
function deleteAction(id){ doPost('delete',{ id }) }
function createAction(){ doPost('create',create) }
const updateAction = debounce(function(field,id,value){ doPost('update',{ id,field,value }) },1200)
</script>
