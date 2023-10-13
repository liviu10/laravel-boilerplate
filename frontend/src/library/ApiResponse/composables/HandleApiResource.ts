import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main'

interface ResourceEndpoint {
  id: number
  name: string
  endpoint: string
}

let apiEndpoint = ''
let resourceEndpoint: ResourceEndpoint | undefined = undefined
const notificationTitle = 'Warning'
const notificationMessage = 'The resource does not exist'

const handleApiResource = (resourceList: ResourceEndpoint[], resourceName: string, storeId: string): string | null => {
  resourceEndpoint = resourceList.find((r) => r.name === resourceName)

  if (resourceEndpoint) {
    apiEndpoint = resourceEndpoint.endpoint

    return apiEndpoint
  } else {
    const context = {
      message: 'Test context'
    }
    handleNotificationSystem(notificationTitle, notificationMessage, 'negative', 'bottom', true)
    console.error(`${handleNotificationSystemLog.value('negative', storeId, context)}`)

    return null
  }
}

export { handleApiResource }
