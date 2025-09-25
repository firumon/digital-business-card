import {inject, nextTick} from "vue";

export function useTitle(resource){
  const setTitleResource = inject('setTitleResource')
  return nextTick(function(){ setTitleResource(resource.value) })
}
