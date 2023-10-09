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

/**
 * Handles the response from an Axios request and transforms it into a structured response object.
 * @param {AxiosResponse} response - The Axios response object.
 * @param {string} storeId - The store identifier.
 * @returns {ListRecordsResponseInterface | null} A structured response object containing
 * columns, description, filters, models, results, and title, or null if the response is not valid.
 */
const handleApiResponse = (response: AxiosResponse, storeId: string): ListRecordsResponseInterface | null => {
  const data = response.data

  if (response.status === 200 && data && Object.keys(data).length) {
    const description = data.description
    const title = data.title
    const hasColumns = data.hasOwnProperty('columns') && Array.isArray(data.columns) && data.columns.length
    const hasFilters = data.hasOwnProperty('filters') && Array.isArray(data.filters) && data.filters.length
    const hasModels = data.hasOwnProperty('models') && Array.isArray(data.models) && data.models.length
    const hasResults = data.hasOwnProperty('results') && Array.isArray(data.results) && data.results.length

    // Extract columns
    const columns: ColumnInterface[] | [] = (hasColumns) ? data.columns : []

    // Extract filters
    const filters: FilterInterface[] | [] = (hasFilters) ? data.filters : []

    // Extract models
    const models: ModelInterface[] | [] = (hasModels) ? data.models : []

    // Extract results
    const results: object[] | [] = (hasResults) ? data.results : []

    return { columns, description, filters, models, results, title }
  } else {
    handleNotificationSystem(notificationTitle, notificationMessage, 'warning', 'bottom', true, data)
    console.warn(`${handleNotificationSystemLog.value('negative', storeId, data)}`)

    return null
  }
}

export {
  ColumnInterface,
  FilterInterface,
  ModelInterface,
  ListRecordsResponseInterface,
  handleApiResponse
}
