import { defineStore, acceptHMRUpdate } from 'pinia'
import {computed, ref} from "vue";
import {api} from "boot/axios.js";
import {find, get, groupBy, keyBy, map} from "lodash";

export const useLayoutStore = defineStore('layout', () => {
  const _Layouts = ref(null)
  const Layouts = computed(() => _Layouts.value || fetchLayouts() || [])
  const LayoutsById = computed(() => keyBy(Layouts.value,'id'))

  const selectOptions = computed(() => map(Layouts.value,layout => ({ label:layout.name,value:layout.id })))

  function fetchLayouts(){ api('layout').then(_props => _Layouts.value = _props) }
  function addNewLayout(data){ return new Promise(resolve => api('layout/save',data).then(_props => _Layouts.value = _props).then(resolve)) }
  function updateLayout(id,data){ return new Promise(resolve => api('layout/update', { id,...data }).then(_props => _Layouts.value = _props).then(resolve)) }
  function addLayoutProperty(id,data){ return new Promise(resolve => api('layout/property', { layout_id:id,...data }).then(_props => _Layouts.value = _props).then(resolve)) }
  function updateLayoutProperty(layout_id,layout_property_id,data){ return new Promise(resolve => api('layout/property_update', { layout_id,layout_property_id,...data }).then(_props => _Layouts.value = _props).then(resolve)) }
  function deleteLayoutProperty(layout_id,layout_property_id){ return new Promise(resolve => api('layout/property_delete', { layout_id,layout_property_id }).then(_props => _Layouts.value = _props).then(resolve)) }
  function updateUsers(layout_id,access_users,role_name){ return new Promise(resolve => api('layout/users_update', { layout_id,access_users,role_name }).then(_props => _Layouts.value = _props).then(resolve)) }
  function deleteLayout(id){ return new Promise(resolve => api('layout/delete', { id }).then(_props => _Layouts.value = _props).then(resolve)) }

  const LayoutProperties = computed(() => (LayoutId,PropertyName) => PropertyName ? find(LayoutsById.value[LayoutId].properties,['name',PropertyName]) : (LayoutsById.value[LayoutId] ?. properties || []))
  const LayoutResellers = computed(() => (LayoutId,AdminId) => AdminId ? get(groupBy(Layouts.value[LayoutId] ?. users,'user_id'),[AdminId,'resellers'],[]) : [])

  return { Layouts,addNewLayout,updateLayout,LayoutsById,LayoutProperties,LayoutResellers,addLayoutProperty,updateLayoutProperty,deleteLayoutProperty,updateUsers,selectOptions }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useLayoutStore, import.meta.hot))
}
