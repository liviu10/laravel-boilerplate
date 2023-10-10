import { ResourceEndpointInterface } from 'src/library/ApiResponse/composables/interfaces'

const communicationResources: ResourceEndpointInterface[] = [
  {
    id: 1,
    name: 'subjects',
    endpoint: '/admin/communication/contact/subjects'
  },
  {
    id: 2,
    name: 'messages',
    endpoint: '/admin/communication/contact/messages'
  },
  {
    id: 3,
    name: 'responses',
    endpoint: '/admin/communication/contact/responses'
  },
  {
    id: 4,
    name: 'campaigns',
    endpoint: '/admin/communication/newsletter/campaigns'
  },
  {
    id: 5,
    name: 'subscribers',
    endpoint: '/admin/communication/newsletter/subscribers'
  },
  {
    id: 6,
    name: 'reviews',
    endpoint: '/admin/communication/reviews'
  }
]

export { communicationResources }
