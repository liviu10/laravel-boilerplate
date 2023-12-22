// Import vue related utilities
import { Cookies } from 'quasar';

// Import library utilities, interfaces and components
import { IAllRecords } from 'src/interfaces/ResourceInterface'
import { IConfiguration, IConfigurationColumn, IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface';

// Import Pinia's related utilities
import { useResourceStore } from 'src/stores/settings/resources';
import { useConfigurationResourceStore } from 'src/stores/settings/configuration_resources';

interface IHandleApi {
  getEndpoint: (path: string, storeId: string) => Promise<void | IAllRecords['results']>;
  getConfiguration: (resourceName: string, storeId: string) => Promise<void | IConfiguration['results']>;
  getColumnConfiguration: (configuration: IConfiguration['results']) => IConfigurationColumn[];
  getDataModelConfiguration: (configuration: IConfiguration['results']) => IConfigurationInput[];
  getFilterModelConfiguration: (configuration: IConfiguration['results']) => IConfigurationInput[];
  getUploadModelConfiguration: (configuration: IConfiguration['results']) => IConfigurationInput[];
  getDownloadModelConfiguration: (configuration: IConfiguration['results']) => IConfigurationInput[];
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

  /**
   * Gets the column configuration from the provided IConfiguration 'results'.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about columns.
   * @returns {IConfigurationColumn[]} - An array of IConfigurationColumn representing the configuration columns.
   */
  public getColumnConfiguration(configuration: IConfiguration['results']): IConfigurationColumn[] {
    const columns = configuration[0].configuration_types[0].configuration_columns

    return columns
  }

  /**
   * Gets the input configuration from the provided IConfiguration 'results' and filters out inactive inputs.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about inputs.
   * @returns {IConfigurationInput[]} - An array of active IConfigurationInput representing the input configuration.
   */
  private getInputConfiguration(configuration: IConfiguration['results']): IConfigurationInput[] {
    const input = configuration[0].configuration_types[1].configuration_inputs.filter(input => input.is_active);

    return input
  }

  /**
   * Gets the data model configuration from the provided IConfiguration 'results' and filters out inactive and non-model inputs.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about inputs.
   * @returns {IConfigurationInput[]} - An array of active and model IConfigurationInput representing the data model configuration.
   */
  public getDataModelConfiguration(configuration: IConfiguration['results']): IConfigurationInput[] {
    let dataModel = this.getInputConfiguration(configuration)
    dataModel = dataModel.filter(model => model.is_model && model.key !== 'upload' && model.key !== 'date_to' && model.key !== 'date_from')

    return dataModel
  }

  /**
   * Gets the filter model configuration from the provided IConfiguration 'results' and filters out inactive and non-filter inputs.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about inputs.
   * @returns {IConfigurationInput[]} - An array of active and filter IConfigurationInput representing the filter model configuration.
   */
  public getFilterModelConfiguration(configuration: IConfiguration['results']): IConfigurationInput[] {
    let filterModel = this.getInputConfiguration(configuration)
    filterModel = filterModel.filter(filter => filter.is_filter && filter.key !== 'upload' && filter.key !== 'date_to' && filter.key !== 'date_from')

    return filterModel
  }

  /**
   * Gets the upload model configuration from the provided IConfiguration 'results'.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about inputs.
   * @returns {IConfigurationInput[]} - An array of IConfigurationInput representing the upload model configuration.
   */
  public getUploadModelConfiguration(configuration: IConfiguration['results']): IConfigurationInput[] {
    let uploadModel = this.getInputConfiguration(configuration)
    uploadModel = uploadModel.filter(model => model.key === 'upload')

    return uploadModel
  }


  /**
   * Gets the download model configuration from the provided IConfiguration 'results'.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about inputs.
   * @returns {IConfigurationInput[]} - An array of IConfigurationInput representing the download model configuration.
   */
  public getDownloadModelConfiguration(configuration: IConfiguration['results']): IConfigurationInput[] {
    let downloadModel = this.getInputConfiguration(configuration)
    downloadModel = downloadModel.filter(model => model.key === 'date_to' || model.key === 'date_from')

    return downloadModel
  }
}
