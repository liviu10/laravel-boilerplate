type TInput =
  | 'number'
  | 'textarea'
  | 'time'
  | 'text'
  | 'password'
  | 'email'
  | 'search'
  | 'tel'
  | 'file'
  | 'url'
  | 'date'
  | undefined;

interface IConfigurationOptions {
  id: number
  value: string
  label: string
  configuration_resource_id: number
  configuration_type_id: number
  configuration_input_id: number
}

interface IConfigurationInput {
  id: number
  accept?: string
  field: string
  is_active: boolean
  is_filter: boolean
  is_model: boolean
  key: string
  name: string
  position: number
  type: TInput
  configuration_resource_id: number
  configuration_type_id: number
  configuration_options?: Pick<IConfigurationOptions, 'value' | 'label'>[],
  value: null
}

interface IHandleObject {
  handleCheckIfArray: (array: unknown | undefined) => boolean;
  handleCheckIfObject: (object: unknown | undefined) => boolean;
  handleActiveInputs: (array: IConfigurationInput[]) => IConfigurationInput[];
  handleActiveInputsDataModel: (array: IConfigurationInput[]) => IConfigurationInput[];
  handleActiveInputsFilterModel: (array: IConfigurationInput[]) => IConfigurationInput[];
  handleActiveInputsUploadModel: (array: IConfigurationInput[]) => IConfigurationInput[];
  handleActiveInputsDownloadModel: (array: IConfigurationInput[]) => IConfigurationInput[];
  handleActiveInputsSearchResourceModel: (array: IConfigurationInput[]) => IConfigurationInput[];
}

export class HandleObject implements IHandleObject {
  /**
   * Checks if the provided value is a non-empty array.
   * @param {unknown | undefined} array - The value to be checked.
   * @returns {boolean} Returns true if the value is a non-empty array, false otherwise.
   */
  public handleCheckIfArray(array: unknown | undefined): boolean {
    return (
      !!array &&
      typeof array === 'object' &&
      Array.isArray(array) &&
      array.length > 0
    );
  }

  /**
   * Checks if the provided object is a non-empty object.
   * @param {unknown | undefined} object - The object to be checked.
   * @returns {boolean} Returns true if the object is a non-empty object, false otherwise.
   */
  public handleCheckIfObject(object: unknown | undefined): boolean {
    return (
      !!object && typeof object === 'object' && Object.keys(object).length > 0
    );
  }

  /**
   * Filters an array of configuration inputs based on their 'is_active' property.
   * @param {IConfigurationInput[]} array - The array of configuration inputs to be filtered.
   * @returns {IConfigurationInput[]} - An array containing only the active configuration inputs.
   */
  public handleActiveInputs(array: IConfigurationInput[]): IConfigurationInput[] {
    return array.filter(
      (activeInput: Pick<IConfigurationInput, 'is_active'>) => activeInput.is_active
    )
  }

  /**
   * Filters an array of configuration inputs based on specific criteria related to data models.
   * @param {IConfigurationInput[]} array - The array of configuration inputs to be filtered.
   * @returns {IConfigurationInput[]} - An array containing configuration inputs that meet the specified data model criteria.
   */
  public handleActiveInputsDataModel(array: IConfigurationInput[]): IConfigurationInput[] {
    return array.filter(
      (model: IConfigurationInput) => model.is_model &&
        model.key !== 'search_resource' &&
        model.key !== 'upload' &&
        model.key !== 'date_to' &&
        model.key !== 'date_from'
    )
  }

  /**
   * Filters an array of configuration inputs based on specific criteria related to filter models.
   * @param {IConfigurationInput[]} array - The array of configuration inputs to be filtered.
   * @returns {IConfigurationInput[]} - An array containing configuration inputs that meet the specified filter model criteria.
   */
  public handleActiveInputsFilterModel(array: IConfigurationInput[]): IConfigurationInput[] {
    return array.filter(
      (filter: IConfigurationInput) => filter.is_model &&
        filter.key !== 'search_resource' &&
        filter.key !== 'upload' &&
        filter.key !== 'date_to' &&
        filter.key !== 'date_from'
    )
  }

  /**
   * Filters an array of configuration inputs to retrieve those specifically related to upload models.
   * @param {IConfigurationInput[]} array - The array of configuration inputs to be filtered.
   * @returns {IConfigurationInput[]} - An array containing configuration inputs related to the 'upload' model.
   */
  public handleActiveInputsUploadModel(array: IConfigurationInput[]): IConfigurationInput[] {
    return array.filter(
      (model: IConfigurationInput) => model.key === 'upload'
    )
  }

  /**
   * Filters an array of configuration inputs to retrieve those specifically related to download models.
   * @param {IConfigurationInput[]} array - The array of configuration inputs to be filtered.
   * @returns {IConfigurationInput[]} - An array containing configuration inputs related to the 'date_to' or 'date_from' models.
   */
  public handleActiveInputsDownloadModel(array: IConfigurationInput[]): IConfigurationInput[] {
    return array.filter(
      (model: IConfigurationInput) => model.key === 'date_to' || model.key === 'date_from'
    )
  }

  /**
   * Filters an array of configuration inputs to retrieve those specifically related to the search resource model.
   * @param {IConfigurationInput[]} array - The array of configuration inputs to be filtered.
   * @returns {IConfigurationInput[]} - An array containing configuration inputs related to the 'search_resource' model.
   */
  public handleActiveInputsSearchResourceModel(array: IConfigurationInput[]): IConfigurationInput[] {
    return array.filter(
      (filter: IConfigurationInput) => filter.key === 'search_resource'
    )
  }
}
