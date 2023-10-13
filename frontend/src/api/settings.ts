import { ResourceEndpoint } from 'src/library/ApiResponse/composables/interfaces'

const settingsResources: ResourceEndpoint[] = [
  {
    id: 1,
    name: 'accepted-domains',
    endpoint: '/admin/settings/accepted-domains'
  },
  {
    id: 2,
    name: 'general',
    endpoint: '/admin/settings/general'
  },
  {
    id: 3,
    name: 'notifications',
    endpoint: '/admin/settings/notifications'
  },
  {
    id: 4,
    name: 'resources',
    endpoint: '/admin/settings/resources'
  },
  {
    id: 5,
    name: 'roles',
    endpoint: '/admin/settings/roles'
  },
  {
    id: 6,
    name: 'users',
    endpoint: '/admin/settings/users'
  }
]

export { settingsResources }
