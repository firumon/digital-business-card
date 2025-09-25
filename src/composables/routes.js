import {useRouter} from "vue-router";
import {useMenuStore} from "stores/menu.js";
import {computed, ref} from "vue";
import {useUserStore} from "stores/user.js";
import {assign, clone, filter, flatMap, keyBy, map, mapValues, set} from "lodash";

const menuLabelIcon = ref(null)
const menuRoutes = ref(null)
const subRoutes = ref(null)
const dynamicTitles = ref(null)
const titleResource = ref(null)
const dynamicParams = ref(null)
const routes = ref(null)
const routeNames = ref(null)
const namedRoutes = ref(null)
const menus = ref(null)
const subMenus = ref(null)
const paramsFn = ref(null)

export function useRoutes(){
  const router = useRouter(), menuStore = useMenuStore(), userStore = useUserStore()
  const role = userStore.User ?. role,
    routeName = computed(() => router.currentRoute.value.name),
    currentRoute = computed(() => namedRoutes.value[routeName]);

  if(!menuLabelIcon.value) menuLabelIcon.value = menuStore.label_icon
  if(!menuRoutes.value) menuRoutes.value = menuStore.role_routes[role]
  if(!subRoutes.value) subRoutes.value = menuStore.sub_routes
  if(!dynamicTitles.value) dynamicTitles.value = menuStore.dynamic_titles
  if(!dynamicParams.value) dynamicParams.value = menuStore.dynamic_params

  if(!routes.value) {
    routes.value = map(router.getRoutes(),function(Route){
      let route = clone(Route), routeName = route.name; if(!routeName) return route;
      if(menuLabelIcon.value.hasOwnProperty(routeName)){
        let labelIcon = menuLabelIcon.value[routeName], title = labelIcon[2] || labelIcon[0];
        route = assign({},route,{ label:labelIcon[0],icon:labelIcon[1],title })
      }
      if(dynamicTitles.value.hasOwnProperty(routeName)) route['titleFn'] = dynamicTitles.value[routeName]
      if(dynamicParams.value.hasOwnProperty(routeName)) route['paramFn'] = dynamicParams.value[routeName]
      return route;
    })
    routeNames.value = filter(map(routes.value,'name'))
    namedRoutes.value = keyBy(routes.value,'name')
  }

  if(!menus.value) menus.value = mapValues(menuRoutes.value,function(routes){
    return filter(map(routes,routeName => namedRoutes.value[routeName]))
  })
  if(!subMenus.value) subMenus.value = mapValues(subRoutes.value,function(routes,parent){
    return filter(map(routes,function(route){
      if(!route.roles.includes(role)) return false;
      let routeName = route.route; if(!routeName || !namedRoutes.value[routeName]) return false;
      return assign({},namedRoutes.value[routeName],route)
    }))
  })

  if(!paramsFn.value){
    const subRoute = mapValues(keyBy(filter(flatMap(subRoutes.value),route => route.hasOwnProperty('params')),'route'),function(route){
      if(!route.hasOwnProperty('params')) return false;
      return route.params
    })
    const mainRoute = mapValues(keyBy(filter(routes.value,route => route.hasOwnProperty('paramFn')),'name'),'paramFn')
    paramsFn.value = ({ ...subRoute,...mainRoute })
  }

  const listMenus = computed(() => subMenus.value[routeName.value])
  const pageTitle = computed(function (){
    const rName = routeName.value
    if(namedRoutes.value[rName] && namedRoutes.value[rName].titleFn && titleResource.value) return namedRoutes.value[rName].titleFn(titleResource.value)
    return namedRoutes.value[rName].title || ''
  })

  function pushRouteObj(toRouteName,resource){
    if(!routeNames.value.includes(toRouteName)) return ({});
    let name = toRouteName, params = ({  });
    if(!resource) return ({ name })
    if(paramsFn.value.hasOwnProperty(name)) params = paramsFn.value[name](resource)
    return ({ name,params })
  }
  function push(toRouteName,params){ return new Promise(resolve => router.push(pushRouteObj(toRouteName,params)).then(() => titleResource.value = null).then(resolve)) }
  function setTitleResource(r){ titleResource.value = r }

  return { routeNames,menus,subMenus,listMenus,pageTitle,namedRoutes,currentRoute,routeName,pushRouteObj,push,setTitleResource }
}
