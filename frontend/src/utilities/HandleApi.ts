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
  getConfigurationId: (resourceName: string) => Promise<void | IConfiguration['results']>;
  createFilterPayload: <T extends IConfigInput>(filterModel?: T[] | undefined, searchResourceModel?: T[] | undefined) => Record<string, string | null>;
  createPayload: <T extends IConfigInput>(model: T[]) => Record<string, string | null>;
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
  public async getConfigurationId(
    resourceName: string
  ): Promise<void | IConfiguration['results']> {
    const configurationResourceStore =
      this.initializeStores().configurationResourceStore;
    await configurationResourceStore.handleGetConfigurationId(resourceName);
    this.configuration = configurationResourceStore.getResourceConfiguration;
    return this.configuration;
  }

  /**
   * Creates a filter payload from an array of configuration inputs and a search resource model.
   * @template T - The type of the configuration input elements.
   * @param {T[] | undefined} filterModel - The array of configuration input elements for filtering.
   * @param {T[] | undefined} searchResourceModel - The array of configuration input elements for searching.
   * @returns {Record<string, string | null>} - The created filter payload with keys and non-null values.
   */
  public createFilterPayload<T extends IConfigInput>(
    filterModel?: T[] | undefined,
    searchResourceModel?: T[] | undefined
  ): Record<string, string | null> {
    const filterPayload: Record<string, string | null> = {};

    if (filterModel) {
      filterModel.forEach((configInput) => {
        if (configInput.value !== null) {
          filterPayload[configInput.key] = configInput.value;
        }
      });
    }

    if (searchResourceModel) {
      searchResourceModel.forEach((configInput) => {
        if (configInput.value !== null) {
          filterPayload[configInput.key] = configInput.value;
        }
      });
    }

    return filterPayload;
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
