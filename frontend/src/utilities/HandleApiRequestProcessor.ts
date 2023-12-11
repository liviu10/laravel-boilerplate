interface IConfigInput {
  key: string;
  value: string | null;
}

interface IHandleApiRequestProcessor {
  createFilterPayload: <T extends IConfigInput>(model: T[]) => Record<string, string | null>
  createPayload: <T extends IConfigInput>(model: T[]) => Record<string, string | null>
}

export class HandleApiRequestProcessor implements IHandleApiRequestProcessor {
  /**
   * Creates a filter payload from an array of configuration inputs.
   * @template T - The type of the configuration input elements.
   * @param {T[]} model - The array of configuration input elements.
   * @returns {Record<string, string | null>} - The created filter payload with keys and non-null values.
   */
  public createFilterPayload<T extends IConfigInput>(model: T[]): Record<string, string | null> {
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
  public createPayload<T extends IConfigInput>(model: T[]): Record<string, string | null> {
    return model.reduce((acc, configInput) => {
      if (configInput.value !== null) {
        acc[configInput.key] = configInput.value;
      }
      return acc;
    }, {} as Record<string, string | null>);
  }
}
