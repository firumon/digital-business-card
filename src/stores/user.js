import { defineStore, acceptHMRUpdate } from 'pinia'
import {computed, ref} from "vue";
import {api} from "boot/axios.js";
import {keyBy} from "lodash";

export const useUserStore = defineStore('user', () => {
  const _Users = ref(null), User = ref(AuthUser)
  const Users = computed(() => _Users.value || fetchUsers() || [])
  const UsersById = computed(() => keyBy(Users.value,'id'))

  function fetchUsers(){ api('user').then(_props => _Users.value = _props) }

  function updateProfileBasic(data){ return new Promise(resolve => { api('profile/update',data).then(_user => User.value = _user).then(resolve) }) }
  function updateProfilePassword(password){ return new Promise(resolve => { api('profile/password', { password }).then(_user => User.value = _user).then(resolve) })}

  function addUser(data,role){ return new Promise(resolve => { api('user/add', { role,...data }).then(_users => _Users.value = _users).then(resolve) }) }

  function updateUserBasic(id,data){ return new Promise(resolve => { api('user/update', { id,...data }).then(_users => _Users.value = _users).then(resolve) }) }
  function updateUserPassword(id,password){ return new Promise(resolve => { api('user/password', { id,password }).then(_users => _Users.value = _users).then(resolve) })}

  return { User,Users,UsersById,updateProfileBasic,updateProfilePassword,addUser,updateUserBasic,updateUserPassword,fetchUsers }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot))
}
