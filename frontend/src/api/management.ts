import { ResourceEndpointInterface } from 'src/library/ApiResponse/composables/interfaces'

const managementResources: ResourceEndpointInterface[] = [
  {
    id: 1,
    name: 'contents',
    endpoint: '/admin/management/contents'
  },
  {
    id: 2,
    name: 'tags',
    endpoint: '/admin/management/tags'
  },
  {
    id: 3,
    name: 'media',
    endpoint: '/admin/management/media'
  },
  {
    id: 4,
    name: 'comments',
    endpoint: '/admin/management/comments'
  },
  {
    id: 5,
    name: 'appreciations',
    endpoint: '/admin/management/appreciations'
  }
]

export { managementResources }
