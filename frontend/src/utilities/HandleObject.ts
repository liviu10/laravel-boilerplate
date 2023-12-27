interface IHandleObject {
  handleCheckIfArray: (array: unknown | undefined) => boolean;
  handleCheckIfObject: (object: unknown | undefined) => boolean;
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
}
