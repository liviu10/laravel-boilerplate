interface IHandleArray {
  handleCheckIfArray: (object: unknown | undefined) => boolean
}

export class HandleArray implements IHandleArray {
  /**
   * Checks if the provided object is a non-empty array.
   * @param {unknown | undefined} object - The object to be checked.
   * @returns {boolean} Returns true if the object is a non-empty array, false otherwise.
   */
  public handleCheckIfArray(object: unknown | undefined): boolean {
    return !!object && typeof object === 'object' && Array.isArray(object) && object.length > 0;
  }
}
