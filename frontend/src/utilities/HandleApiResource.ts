// Import vue related utilities
import { Cookies } from 'quasar';

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
   * Calls the specified API endpoint using the current path.
   * This method handles the API endpoint using the `resourceStore` and updates
   * the `apiEndpointUrl` property accordingly.
   * @param {string} resourceName - The name for the store resource.
   * @param {string} storeId - The store ID associated with the API call.
   * @returns {Promise<void | IAllRecords['results']>} A Promise that resolves with the API endpoint URL or void if an error occurs.
   */
  public async apiEndpoint(resourceName: string, storeId: string): Promise<void | IAllRecords['results']> {
    if (Cookies.has(`endpoint_${resourceName.toLowerCase()}_${storeId}`)) {
      return this.apiEndpointUrl = Cookies.get(`endpoint_${resourceName.toLowerCase()}_${storeId}`)
    } else {
      try {
        const pathName = window.location.pathname
        await resourceStore.handleApiEndpoint(pathName)
        this.apiEndpointUrl = resourceStore.getApiEndpoint
        Cookies.set(`endpoint_${resourceName.toLowerCase()}_${storeId}`, JSON.stringify(this.apiEndpointUrl))

        return this.apiEndpointUrl
      } catch (error) {
        console.log('-> catch', error)
      } finally {
        console.log('-> finally')
      }
    }
  }
}
