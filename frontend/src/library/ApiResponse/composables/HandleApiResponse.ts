import { AxiosResponse } from 'axios'
import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main'
import { ColumnInterface, FilterInterface, IndexResponseInterface, ModelInterface } from './interfaces'

const notificationTitle = 'Warning'
const notificationMessage = 'Something went wrong'

/**
 * Handles the response from an Axios request and transforms it into a structured response object.
 * @param {AxiosResponse} response - The Axios response object.
 * @param {string} storeId - The store identifier.
 * @returns {IndexResponseInterface | null} A structured response object containing
 * columns, description, filters, models, results, and title, or null if the response is not valid.
 */
const handleApiResponse = (response: AxiosResponse, storeId: string): IndexResponseInterface | null => {
  const data = response.data

  if (response.status === 200 || response.status === 201 && data && Object.keys(data).length) {
    const description = data.description
    const title = data.title

    // Extract columns
    const columns: ColumnInterface[] | [] = handleExtractColumns(data)

    // Extract filters
    const filters: FilterInterface[] | [] = handleExtractFilters(data)

    // Extract models
    const models: ModelInterface[] | [] = handleExtractModels(data)

    // Extract results
    const results: object[] | [] = handleExtractResults(data)

    return { columns, description, filters, models, results, title }
  } else {
    handleNotificationSystem(notificationTitle, notificationMessage, 'warning', 'bottom', true, data)
    console.warn(`${handleNotificationSystemLog.value('negative', storeId, data)}`)

    return null
  }
}

/**
 * Extracts the 'columns' property from an IndexResponseInterface object.
 * @param {IndexResponseInterface} data - The response data containing 'columns'.
 * @returns {ColumnInterface[] | []} An array of columns or an empty array if 'columns' is not found or not valid.
 */
const handleExtractColumns = (data: IndexResponseInterface): ColumnInterface[] | [] => {
  return (data.hasOwnProperty('columns') && Array.isArray(data.columns) && data.columns.length)
    ? data.columns
    : [];
}

/**
 * Extracts the 'filters' property from an IndexResponseInterface object.
 * @param {IndexResponseInterface} data - The response data containing 'filters'.
 * @returns {FilterInterface[] | []} An array of filters or an empty array if 'filters' is not found or not valid.
 */
const handleExtractFilters = (data: IndexResponseInterface): FilterInterface[] | [] => {
  return (data.hasOwnProperty('filters') && Array.isArray(data.filters) && data.filters.length)
    ? data.filters
    : [];
}

/**
 * Extracts the 'models' property from an IndexResponseInterface object.
 * @param {IndexResponseInterface} data - The response data containing 'models'.
 * @returns {ModelInterface[] | []} An array of models or an empty array if 'models' is not found or not valid.
 */
const handleExtractModels = (data: IndexResponseInterface): ModelInterface[] | [] => {
  return (data.hasOwnProperty('models') && Array.isArray(data.models) && data.models.length)
    ? data.models
    : [];
}

/**
 * Extracts the 'results' property from an IndexResponseInterface object.
 * @param {IndexResponseInterface} data - The response data containing 'results'.
 * @returns {object[] | []} An array of results or an empty array if 'results' is not found or not valid.
 */
const handleExtractResults = (data: IndexResponseInterface): object[] | [] => {
  return (data.hasOwnProperty('results') && typeof data.results === 'object' && Object.keys(data.results).length)
    ? data.results
    : [];
}

export { handleApiResponse }
