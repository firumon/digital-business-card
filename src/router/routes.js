const app_routes = {
  properties_list: { name:'properties_list', path: 'Properties', component: () => import('pages/Property/List.vue') },
  property_add: { name:'property_add', path: 'Property/Add', component: () => import('pages/Property/Add.vue') },
  layouts_list: { name:'layouts_list', path: 'Layouts', component: () => import('pages/Layout/List.vue') },
  layout_add: { name:'layout_add', path: 'Layout/Add', component: () => import('pages/Layout/Add.vue') },
  layout_detail: { name:'layout_detail', path: 'Layout/:id/Detail', component: () => import('pages/Layout/Detail.vue'), props:true },
  layout_properties: { name:'layout_properties', path: 'Layout/Properties/:layout_id?', component: () => import('pages/Layout/Properties.vue'), props:true, },
  layout_users: { name:'layout_users', path: 'Layout/Users/:layout_id?', component: () => import('pages/Layout/Users.vue'), props:true, },
  profile: { name:'profile', path: 'Profile', component: () => import('pages/Profile/Index.vue') },
  manage_admins: { name:'manage_admins', path: 'Admin', component: () => import('pages/Admin/Manage.vue') },
  manage_resellers: { name:'manage_resellers', path: 'Reseller', component: () => import('pages/Reseller/Manage.vue') },
  manage_managers: { name:'manage_managers', path: 'Manager', component: () => import('pages/Manager/Manage.vue') },
  companies_list: { name:'companies_list', path: 'Companies', component: () => import('pages/Company/List.vue') },
  company_add: { name:'company_add', path: 'Company/Add', component: () => import('pages/Company/Add.vue') },
  company_detail: { name:'company_detail', path: 'Company/:id/Detail', component: () => import('pages/Company/Detail.vue'),props: true },
  individuals: { name:'individuals', path: 'Individuals', component: () => import('pages/Individual/SelectCompany.vue') },
  company_properties: { name:'company_properties', path: 'Company/Properties/:company_id?', component: () => import('pages/Company/Properties.vue'),props: true },
  company_individuals: { name:'company_individuals', path: 'Company/:company_id/Individuals', component: () => import('pages/Company/Individuals.vue'),props: true },
  company_individual: { name:'company_individual', path: 'Company/:company_id/Individual/:individual_id', component: () => import('pages/Individual/Detail.vue'),props: true },
  company_users: { name:'company_users', path: 'Company/Users/:company_id?', component: () => import('pages/Company/Users.vue'),props: true },
  reseller_companies: { name:'reseller_companies', path: 'Reseller/Companies/:reseller_id?', component: () => import('pages/Reseller/Companies.vue'), props: true },
  manager_companies: { name:'manager_companies', path: 'Manager/Companies/:manager_id?', component: () => import('pages/Manager/Companies.vue'), props: true },
  individual_company_individuals: { name:'company_individuals', path: 'Company/:company_id/Individuals', component: () => import('pages/Individual/Individuals.vue'),props: true },
  individual_logins: { name:'individual_logins', path: 'Individual/Logins', component: () => import('pages/Individual/Logins.vue') },
  individual_login_manage: { name:'individual_login_manage', path: 'Individual/Logins/:user_id/Manage', component: () => import('pages/Individual/LoginManage.vue'), props: true },
}
function publicRoute(){
  return {
    path: '/',
    component: () => import('layouts/Public.vue'),
    children: [
      { path: ':individual_code', name:'index', component: () => import('pages/Public/Index.vue') },
    ]
  }
}
function loginRoute(){
  return {
    path: '/login',
    component: () => import('layouts/Login.vue'),
    children: [
      { path: '', name:'index', component: () => import('pages/Login/Index.vue') },
    ]
  }
}
function administratorRoute(){
  return {
    path: '/Administrator',
    component: () => import('layouts/User.vue'),
    children: [
      { path: '', name:'index', component: () => import('pages/Landing/Administrator.vue') },
      app_routes.profile,
      app_routes.manage_resellers, app_routes.reseller_companies,
      app_routes.manage_managers, app_routes.manager_companies,
      app_routes.layouts_list, app_routes.layout_users,
      app_routes.companies_list, app_routes.company_add, app_routes.company_detail, app_routes.company_individuals, app_routes.company_properties, app_routes.company_users,
      app_routes.individuals, app_routes.company_individual, app_routes.individual_logins, app_routes.individual_login_manage,
    ]
  }
}
function resellerRoute(){
  return {
    path: '/Reseller',
    component: () => import('layouts/User.vue'),
    children: [
      { path: '', name:'index', component: () => import('pages/Landing/Reseller.vue') },
      app_routes.profile,
      app_routes.manage_managers, app_routes.manager_companies,
      app_routes.companies_list, app_routes.company_add, app_routes.company_detail, app_routes.company_individuals, app_routes.company_properties, app_routes.company_users,
      app_routes.individuals, app_routes.company_individual, app_routes.individual_logins, app_routes.individual_login_manage,
    ]
  }
}
function developerRoute(){
  return {
    path: '/Developer',
    component: () => import('layouts/User.vue'),
    children: [
      { path: '', name:'index', component: () => import('pages/Landing/Developer.vue') },
      app_routes.properties_list, app_routes.property_add,
      app_routes.layouts_list, app_routes.layout_add, app_routes.layout_detail, app_routes.layout_properties, app_routes.layout_users,
      app_routes.profile,
      app_routes.manage_admins,
    ]
  }
}
function managerRoute(){
  return {
    path: '/Manager',
    component: () => import('layouts/User.vue'),
    children: [
      { path: '', name:'index', component: () => import('pages/Landing/Manager.vue') },
      app_routes.individuals, app_routes.company_individual, app_routes.individual_logins, app_routes.individual_login_manage,
      app_routes.companies_list, app_routes.company_detail, app_routes.company_individuals, app_routes.company_properties,
      app_routes.profile,
    ]
  }
}
function IndividualRoute(){
  return {
    path: '/Individual',
    component: () => import('layouts/User.vue'),
    children: [
      { path: '', name:'index', component: () => import('pages/Landing/Individual.vue') },
      app_routes.individuals, app_routes.company_individual, app_routes.individual_company_individuals,
      app_routes.profile,
    ]
  }
}
function locationWiseRoute(){
  const pathName = location.pathname.split('/')[1];
  switch (pathName){
    case 'login': return loginRoute();
    case 'Developer': return developerRoute();
    case 'Administrator': return administratorRoute();
    case 'Reseller': return resellerRoute();
    case 'Manager': return managerRoute();
    case 'Individual': return IndividualRoute();
    default: return publicRoute();
  }
}

const routes = [
  locationWiseRoute(),
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
].filter(R => R)

export default routes
