// Import vue related utilities
// import { Cookies } from 'quasar';

// Import library utilities, interfaces and components
import {
  IConfiguration,
  IConfigurationColumn,
  IConfigurationInput,
} from 'src/interfaces/ConfigurationResourceInterface';

// Import Pinia's related utilities
import { useResourceStore } from 'src/stores/settings/resources';
import { useConfigurationResourceStore } from 'src/stores/settings/configuration_resources';

interface IHandleApi {
  getEndpoint: () => Promise<string | undefined | void>;
  getConfiguration: (
    resourceName: string
  ) => Promise<void | IConfiguration['results']>;
  getColumnConfiguration: (
    configuration: IConfiguration['results']
  ) => IConfigurationColumn[];
  getDataModelConfiguration: (
    configuration: IConfiguration['results']
  ) => IConfigurationInput[];
  getFilterModelConfiguration: (
    configuration: IConfiguration['results']
  ) => IConfigurationInput[];
  getUploadModelConfiguration: (
    configuration: IConfiguration['results']
  ) => IConfigurationInput[];
  getDownloadModelConfiguration: (
    configuration: IConfiguration['results']
  ) => IConfigurationInput[];
  createFilterPayload: <T extends IConfigInput>(
    model: T[]
  ) => Record<string, string | null>;
  createPayload: <T extends IConfigInput>(
    model: T[]
  ) => Record<string, string | null>;
}

interface IConfigInput {
  key: string;
  value: string | null;
}

export class HandleApi implements IHandleApi {
  endpointUrl: string | undefined;
  configuration: IConfiguration['results'];

  public constructor() {
    this.endpointUrl = undefined;
    this.configuration = [];
  }

  private initializeStores() {
    return {
      resourceStore: useResourceStore(),
      configurationResourceStore: useConfigurationResourceStore(),
    };
  }

  /**
   * Retrieves the API endpoint for a given resource and store.
   * @returns {Promise<string | undefined>} A Promise that resolves to the API endpoint URL, or undefined if not found.
   */
  public async getEndpoint(): Promise<string | undefined | void> {
    const resourceStore = this.initializeStores().resourceStore;
    const pathName = window.location.pathname;
    await resourceStore.handleApiEndpoint(pathName);
    this.endpointUrl = resourceStore.getApiEndpoint[0].path;
    return this.endpointUrl;
  }

  /**
   * Retrieves the configuration for a given resource.
   * @param {string} resourceName - The name of the resource.
   * @returns {Promise<void | IConfiguration['results']>} A Promise that resolves to the configuration results,
   * or void if there is an issue in handling the configuration retrieval.
   */
  public async getConfiguration(
    resourceName: string
  ): Promise<void | IConfiguration['results']> {
    const configurationResourceStore =
      this.initializeStores().configurationResourceStore;
    await configurationResourceStore.handleGetConfigurations(resourceName);
    this.configuration = configurationResourceStore.getResourceConfiguration;
    return this.configuration;
  }

  /**
   * Gets the column configuration from the provided IConfiguration 'results'.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about columns.
   * @returns {IConfigurationColumn[]} - An array of IConfigurationColumn representing the configuration columns.
   */
  public getColumnConfiguration(
    configuration: IConfiguration['results']
  ): IConfigurationColumn[] {
    const columns =
      configuration[0].configuration_types[0].configuration_columns;

    return columns;
  }

  /**
   * Gets the input configuration from the provided IConfiguration 'results' and filters out inactive inputs.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about inputs.
   * @returns {IConfigurationInput[]} - An array of active IConfigurationInput representing the input configuration.
   */
  private getInputConfiguration(
    configuration: IConfiguration['results']
  ): IConfigurationInput[] {
    const input =
      configuration[0].configuration_types[1].configuration_inputs.filter(
        (input) => input.is_active
      );

    return input;
  }

  /**
   * Gets the data model configuration from the provided IConfiguration 'results' and filters out inactive and non-model inputs.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about inputs.
   * @returns {IConfigurationInput[]} - An array of active and model IConfigurationInput representing the data model configuration.
   */
  public getDataModelConfiguration(
    configuration: IConfiguration['results']
  ): IConfigurationInput[] {
    let dataModel = this.getInputConfiguration(configuration);
    dataModel = dataModel.filter(
      (model) =>
        model.is_model &&
        model.key !== 'upload' &&
        model.key !== 'date_to' &&
        model.key !== 'date_from'
    );

    return dataModel;
  }

  /**
   * Gets the filter model configuration from the provided IConfiguration 'results' and filters out inactive and non-filter inputs.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about inputs.
   * @returns {IConfigurationInput[]} - An array of active and filter IConfigurationInput representing the filter model configuration.
   */
  public getFilterModelConfiguration(
    configuration: IConfiguration['results']
  ): IConfigurationInput[] {
    let filterModel = this.getInputConfiguration(configuration);
    filterModel = filterModel.filter(
      (filter) =>
        filter.is_filter &&
        filter.key !== 'upload' &&
        filter.key !== 'date_to' &&
        filter.key !== 'date_from'
    );

    return filterModel;
  }

  /**
   * Gets the upload model configuration from the provided IConfiguration 'results'.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about inputs.
   * @returns {IConfigurationInput[]} - An array of IConfigurationInput representing the upload model configuration.
   */
  public getUploadModelConfiguration(
    configuration: IConfiguration['results']
  ): IConfigurationInput[] {
    let uploadModel = this.getInputConfiguration(configuration);
    uploadModel = uploadModel.filter((model) => model.key === 'upload');

    return uploadModel;
  }

  /**
   * Gets the download model configuration from the provided IConfiguration 'results'.
   * @param {IConfiguration['results']} configuration - The configuration results containing information about inputs.
   * @returns {IConfigurationInput[]} - An array of IConfigurationInput representing the download model configuration.
   */
  public getDownloadModelConfiguration(
    configuration: IConfiguration['results']
  ): IConfigurationInput[] {
    let downloadModel = this.getInputConfiguration(configuration);
    downloadModel = downloadModel.filter(
      (model) => model.key === 'date_to' || model.key === 'date_from'
    );

    return downloadModel;
  }

  /**
   * Creates a filter payload from an array of configuration inputs.
   * @template T - The type of the configuration input elements.
   * @param {T[]} model - The array of configuration input elements.
   * @returns {Record<string, string | null>} - The created filter payload with keys and non-null values.
   */
  public createFilterPayload<T extends IConfigInput>(
    model: T[]
  ): Record<string, string | null> {
    return model.reduce((acc, configInput) => {
      if (configInput.value !== null) {
        acc[configInput.key] = configInput.value;
      }
      return acc;
    }, {} as Record<string, string | null>);
  }

  /**
   * Creates a payload from an array of configuration inputs.
   * @template T - The type of the configuration input elements.
   * @param {T[]} model - The array of configuration input elements.
   * @returns {Record<string, string | null>} - The created payload with keys and values.
   */
  public createPayload<T extends IConfigInput>(
    model: T[]
  ): Record<string, string | null> {
    return model.reduce((acc, configInput) => {
      if (configInput.value !== null) {
        acc[configInput.key] = configInput.value;
      }
      return acc;
    }, {} as Record<string, string | null>);
  }
}
