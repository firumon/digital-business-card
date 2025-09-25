import { defineStore, acceptHMRUpdate } from 'pinia'
import {api} from "boot/axios.js";
import {useUserStore} from "stores/user.js";

export const useIndividualStore = defineStore('individual', () => {
  function createAndAddUser(individual_id,user_details){ return new Promise(resolve => api('individual/user', { individual_id,user:user_details }).then(_props => useUserStore().fetchUsers() || _props).then(resolve)) }
  return {}
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useIndividualStore, import.meta.hot))
}
