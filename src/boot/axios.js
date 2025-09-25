import { defineBoot } from '#q-app/wrappers'
import axios from 'axios'

// Be careful when using SSR for cross-request state pollution
// due to creating a Singleton instance here;
// If any client changes this (global) instance, it might be a
// good idea to move this instance creation inside of the
// "export default () => {}" function below (which runs individually
// for each client)
const apiInstance = axios.create({
  baseURL: [location.origin,location.pathname.split("/")[1],"api"].join("/"),
  headers: {'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0]?.content },
  method: "post",
})

export default defineBoot(({ app }) => {
  app.config.globalProperties.$api = apiInstance
})

function api(path,params){ return new Promise((resolve, reject) => apiInstance(path,{ params }).then(({ data }) => resolve(data)).catch(reject)) }
export { api }
