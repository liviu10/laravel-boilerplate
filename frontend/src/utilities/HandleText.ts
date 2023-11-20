interface IHandleText {
  handleFormatText: (text?: string | undefined) => string
}

export class HandleText implements IHandleText {
  pattern: RegExp
  basicText: string

  public constructor() {
    this.pattern = /[^a-zA-Z ]/g
    this.basicText = 'Basic text'
  }

  /**
   * Formats the input text by capitalizing the first letter and replacing a specified pattern.
   * @param {string | undefined} text - The input text to be formatted.
   * @returns {string} The formatted text, with the first letter capitalized and the specified pattern replaced.
   */
  public handleFormatText(text?: string | undefined): string {
    if (text && text !== undefined) {
      return text.charAt(0).toUpperCase() + text.slice(1).replace(this.pattern, ' ')
    } else {
      return this.basicText
    }
  }
}
