// Import vue related utilities
// import { Cookies } from 'quasar';

interface IHandleApi {
  createFilterPayload: <T extends IConfigInput>(filterModel?: T[] | undefined, searchResourceModel?: T[] | undefined) => Record<string, string | null>;
  createPayload: <T extends IConfigInput>(model: T[]) => Record<string, string | null>;
}

interface IConfigInput {
  key: string;
  value: string | null;
}

export class HandleApi implements IHandleApi {
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
