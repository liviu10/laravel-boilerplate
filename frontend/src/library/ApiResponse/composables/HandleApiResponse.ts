import { AxiosResponse } from 'axios'
import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main'
import { Column, Filter, IndexResponse, Model } from './interfaces'

const notificationTitle = 'Warning'
const notificationMessage = 'Something went wrong'

/**
 * Handles the response from an Axios request and transforms it into a structured response object.
 * @param {AxiosResponse} response - The Axios response object.
 * @param {string} storeId - The store identifier.
 * @returns {IndexResponse | null} A structured response object containing
 * columns, description, filters, models, results, and title, or null if the response is not valid.
 */
const handleApiResponse = (response: AxiosResponse, storeId: string): IndexResponse | null => {
  const data = response.data

  if (response.status === 200 || response.status === 201 && data && Object.keys(data).length) {
    const description = data.description
    const title = data.title

    // Extract columns
    const columns: Column[] | [] = handleExtractColumns(data)

    // Extract filters
    const filters: Filter[] | [] = handleExtractFilters(data)

    // Extract models
    const models: Model[] | [] = handleExtractModels(data)

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
 * Extracts the 'columns' property from an IndexResponse object.
 * @param {IndexResponse} data - The response data containing 'columns'.
 * @returns {Column[] | []} An array of columns or an empty array if 'columns' is not found or not valid.
 */
const handleExtractColumns = (data: IndexResponse): Column[] | [] => {
  return (data.hasOwnProperty('columns') && Array.isArray(data.columns) && data.columns.length)
    ? data.columns
    : [];
}

/**
 * Extracts the 'filters' property from an IndexResponse object.
 * @param {IndexResponse} data - The response data containing 'filters'.
 * @returns {Filter[] | []} An array of filters or an empty array if 'filters' is not found or not valid.
 */
const handleExtractFilters = (data: IndexResponse): Filter[] | [] => {
  return (data.hasOwnProperty('filters') && Array.isArray(data.filters) && data.filters.length)
    ? data.filters
    : [];
}

/**
 * Extracts the 'models' property from an IndexResponse object.
 * @param {IndexResponse} data - The response data containing 'models'.
 * @returns {Model[] | []} An array of models or an empty array if 'models' is not found or not valid.
 */
const handleExtractModels = (data: IndexResponse): Model[] | [] => {
  return (data.hasOwnProperty('models') && Array.isArray(data.models) && data.models.length)
    ? data.models
    : [];
}

/**
 * Extracts the 'results' property from an IndexResponse object.
 * @param {IndexResponse} data - The response data containing 'results'.
 * @returns {object[] | []} An array of results or an empty array if 'results' is not found or not valid.
 */
const handleExtractResults = (data: IndexResponse): object[] | [] => {
  return (data.hasOwnProperty('results') && typeof data.results === 'object' && Object.keys(data.results).length)
    ? data.results
    : [];
}

export { handleApiResponse }
