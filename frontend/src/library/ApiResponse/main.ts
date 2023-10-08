import { AxiosResponse } from 'axios'
import { handleNotificationSystem, handleNotificationSystemLog } from '../NotificationSystem/main'
import { InputType } from 'src/types/InputType'

interface ListRecordsResponseInterface {
  columns?: ColumnInterface[] | []
  description: string
  filters?: FilterInterface[] | []
  models?: ModelInterface[] | []
  results?: object[] | []
  title: string
}

interface ColumnInterface {
  align: string
  field: string
  headerStyles: string
  id: number
  label: string
  name: string
  style: string
}

interface FilterInterface {
  field: string
  id: number
  is_active: boolean
  key: string
  name: string
  type: InputType
  value: null
}

interface ModelInterface {
  field: string
  id: number
  is_active: boolean
  key: string
  name: string
  type: InputType
  value: null
}

const notificationTitle = 'Warning'
const notificationMessage = 'Something went wrong'

const handleApiResponse = (response: AxiosResponse, storeId: string): ListRecordsResponseInterface | null => {
  const data = response.data

  if (response.status === 200 && data && Object.keys(data).length) {
    const description = data.description
    const title = data.title

    const columns: ColumnInterface[] | [] = (data.hasOwnProperty('columns') && Array.isArray(data.columns) && data.columns.length)
      ? data.columns
      : []

    const filters: FilterInterface[] | [] = (data.hasOwnProperty('filters') && Array.isArray(data.filters) && data.filters.length)
      ? data.filters
      : []

    const models: ModelInterface[] | [] = (data.hasOwnProperty('models') && Array.isArray(data.models) && data.models.length)
      ? data.models
      : []

    const results: object[] | [] = (data.hasOwnProperty('results') && Array.isArray(data.results) && data.results.length)
      ? data.results
      : []

    return { columns, description, filters, models, results, title }
  } else {
    handleNotificationSystem(notificationTitle, notificationMessage, 'warning', 'bottom', true, data)
    console.warn(`${handleNotificationSystemLog.value('negative', storeId, data)}`)

    return null
  }
}

export {
  ListRecordsResponseInterface,
  ColumnInterface,
  FilterInterface,
  ModelInterface,
  handleApiResponse
}
