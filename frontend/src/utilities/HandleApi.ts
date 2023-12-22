// Import vue related utilities
import { Cookies } from 'quasar';

// Import library utilities, interfaces and components
import { IAllRecords } from 'src/interfaces/ResourceInterface'
import { IConfiguration } from 'src/interfaces/ConfigurationResourceInterface';

// Import Pinia's related utilities
import { useResourceStore } from 'src/stores/settings/resources';
import { useConfigurationResourceStore } from 'src/stores/settings/configuration_resources';

interface IHandleApi {
  getEndpoint: (path: string, storeId: string) => Promise<void | IAllRecords['results']>;
  getConfiguration: (resourceName: string, storeId: string) => Promise<void | IConfiguration['results']>;
}

export class HandleApi implements IHandleApi {
  endpointUrl: IAllRecords['results']
  configuration: IConfiguration['results']

  public constructor() {
    this.endpointUrl = []
    this.configuration = []
  }

  private initializeStores() {
    return {
      resourceStore: useResourceStore(),
      configurationResourceStore: useConfigurationResourceStore(),
    };
  }

  /**
   * Retrieves the API endpoint URL for a specified resource.
   * @param {string} resourceName - The name of the resource for which to fetch the API endpoint.
   * @param {string} storeId - The identifier for the store associated with the API endpoint.
   * @returns {Promise<void | IAllRecords['results']>} A Promise resolving to the API endpoint results,
   * or void if the endpoint retrieval fails.
   */
  public async getEndpoint(resourceName: string, storeId: string): Promise<void | IAllRecords['results']> {
    const resourceStore = this.initializeStores().resourceStore;

    if (Cookies.has(`endpoint_${resourceName}_${storeId}`)) {
      return this.endpointUrl = Cookies.get(`endpoint_${resourceName}_${storeId}`)
    } else {
      try {
        const pathName = window.location.pathname
        await resourceStore.handleApiEndpoint(pathName)
        this.endpointUrl = resourceStore.getApiEndpoint
        Cookies.set(`endpoint_${resourceName}_${storeId}`, JSON.stringify(this.endpointUrl))

        return this.endpointUrl
      } catch (error) {
        console.log('-> catch', error)
      } finally {
        console.log('-> finally')
      }
    }
  }

  /**
   * Retrieves configuration data for a specified resource.
   * @param {string} resourceName - The name of the resource for which to fetch the configuration.
   * @param {string} storeId - The identifier for the store associated with the configuration.
   * @returns {Promise<void | IConfiguration['results']>} A Promise resolving to the configuration results,
   * or void if the configuration retrieval fails.
   */
  public async getConfiguration(resourceName: string, storeId: string): Promise<void | IConfiguration['results']> {
    const configurationResourceStore = this.initializeStores().configurationResourceStore;

    if (Cookies.has(`configuration_${resourceName}_${storeId}`)) {
      return this.configuration = Cookies.get(`configuration_${resourceName}_${storeId}`)
    } else {
      try {
        await configurationResourceStore.handleGetConfigurations(resourceName)
        this.configuration = configurationResourceStore.getResourceConfiguration
        Cookies.set(`configuration_${resourceName}_${storeId}`, JSON.stringify(this.configuration))

        return this.configuration
      } catch (error) {
        console.log('-> catch', error)
      } finally {
        console.log('-> finally')
      }
    }
  }
}
