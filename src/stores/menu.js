import { defineStore, acceptHMRUpdate } from 'pinia'
import {ref} from "vue";

export const useMenuStore = defineStore('menu', () => {
  const label_icon = ref({
    // Menu Label, Icon Name, Page Title
    index: ['Dashboard',''],
    properties_list: ['Properties','fact_check'],
    property_add: ['Add New Property','add'],
    layouts_list: ['Layouts','view_column'],
    layout_add: ['Add New Layout','margin'],
    layout_properties: ['Manage Properties','generating_tokens'],
    layout_users: ['Manage Users','supervised_user_circle'],
    profile: ['Profile','manage_accounts'],
    manage_admins: ['Administrators','assignment_ind'],
    manage_resellers: ['Resellers','attribution'],
    manage_managers: ['Managers','assignment_ind'],
    companies_list: ['Companies','foundation'],
    company_add: ['Add New Company','add_business'],
    individuals: ['Individuals','camera_front','Select Company'],
    company_properties: ['Properties','widgets'],
    company_users: ['Managers','groups_3'],
    reseller_companies: ['Companies','business'],
    manager_companies: ['Companies','business'],
    company_individuals: ['Individuals','camera_front'],
    individual_logins: ['Logins','login','Individual Logins'],
  })
  const role_routes = ref({
    Developer: {
      Properties: ['properties_list','property_add'],
      Layout: ['layouts_list','layout_add','layout_properties','layout_users'],
      Administrators: ['manage_admins'],
    },
    Administrator: {
      Individual: ['individuals','individual_logins'],
      Company: ['companies_list','company_add','company_properties','company_users'],
      Layout: ['layouts_list','layout_users'],
      Resellers: ['manage_resellers','reseller_companies'],
      Managers: ['manage_managers','manager_companies'],
    },
    Reseller: {
      Individual: ['individuals','individual_logins'],
      Company: ['companies_list','company_add','company_properties','company_users'],
      Managers: ['manage_managers','manager_companies'],
    },
    Manager: {
      Individual: ['individuals','individual_logins'],
      Company: ['companies_list','company_properties'],
    },
    Individual: {
      Individual: ['individuals'],
    },
  })
  const sub_routes = ref({
    layouts_list: [
      { route:'layout_properties',roles:['Developer'],params:({ id }) => ({ layout_id:id }), label:'Properties', icon:'new_label' },
      { route:'layout_users',roles:['Developer'],params:({ id }) => ({ layout_id:id }), label:'Assign Users', icon:'supervised_user_circle'  },
      { route: 'layout_users',roles:['Administrator'],params: ({id}) => ({layout_id: id}), label: 'Assign Resellers' },
    ],
    companies_list: [
      { route:'company_individuals',roles:['Administrator','Reseller'],params:({ id }) => ({ company_id:id }) },
      { route:'company_properties',roles:['Administrator','Reseller'],params:({ id }) => ({ company_id:id }) },
      { route:'company_users',roles:['Administrator','Reseller'],params:({ id }) => ({ company_id:id }) },
    ]
  })
  const dynamic_params = ref({
    company_detail: (resource) => ({ id:resource.id }),
    layout_detail: (resource) => ({ id:resource.id }),
    company_individual: (resource) => ({ company_id:resource.company_id,individual_id:resource.id }),
    individual_login_manage: (resource) => ({ user_id:resource.id }),
  })
  const dynamic_titles = ref({
    company_individuals: (resource) => resource.name + ' Individuals',
    company_properties: (resource) => resource.name + ' Properties',
    company_users: (resource) => resource.name + ' Managers',
    company_individual: (resource) => resource.name,
    company_detail: (resource) => resource.name,
    layout_users: (resource) => resource.name + ' Users',
    layout_detail: (resource) => resource.name,
    individual_login_manage: (resource) => resource.name,
  })

  return { label_icon,role_routes,sub_routes,dynamic_params,dynamic_titles }
})

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useMenuStore, import.meta.hot))
}
