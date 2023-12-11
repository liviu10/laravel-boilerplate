// Import library utilities, interfaces and components
import { IAllRecords } from 'src/interfaces/ResourceInterface'

// Import Pinia's related utilities
import { useResourceStore } from 'src/stores/settings/resources';

// Instantiate the pinia store
const resourceStore = useResourceStore();

interface IHandleApiResource {
  apiEndpoint: (path: string, storeId: string) => Promise<void | IAllRecords['results']>;
}

export class HandleApiResource implements IHandleApiResource {
  apiEndpointUrl: IAllRecords['results']

  public constructor() {
    this.apiEndpointUrl = []
  }

  /**
   * Calls the specified API endpoint using the given path and store ID.
   * This method handles the API endpoint using the `resourceStore` and updates
   * the `apiEndpointUrl` property accordingly.
   * @param {string} path - The path for the API endpoint.
   * @param {string} storeId - The store ID associated with the API call.
   * @returns {Promise<void | IAllRecords['results']>} A Promise that resolves with the API endpoint URL or void if an error occurs.
   */
  public async apiEndpoint(path: string, storeId: string): Promise<void | IAllRecords['results']> {
    try {
      console.log('--> storeId:', storeId) // TODO: based on the storeId save this.apiEndpointUrl to local storage in order to avoid calling resourceStore.handleApiEndpoint
      await resourceStore.handleApiEndpoint(path)
      this.apiEndpointUrl = resourceStore.getApiEndpoint

      return this.apiEndpointUrl
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }
}
