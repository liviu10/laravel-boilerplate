interface IConfigInput {
  key: string;
  value: string | null;
}

interface IHandleApiRequestProcessor {
  createPayload: <T extends IConfigInput>(model: T[]) => Record<string, string | null>
}

export class HandleApiRequestProcessor implements IHandleApiRequestProcessor {
  /**
   * Creates a payload from an array of configuration inputs.
   * @template T - The type of the configuration input elements.
   * @param {T[]} model - The array of configuration input elements.
   * @returns {Record<string, string | null>} - The created payload with keys and values.
   */
  public createPayload<T extends IConfigInput>(model: T[]): Record<string, string | null> {
    return model.reduce((acc, configInput) => {
      acc[configInput.key] = configInput.value;
      return acc;
    }, {} as Record<string, string | null>);
  }
}
