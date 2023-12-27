interface IHandleText {
  handleFormatText: (text?: string | undefined) => string;
  handleTranslationString: (text?: string | undefined) => string;
}

export class HandleText implements IHandleText {
  pattern: RegExp;
  basicText: string;
  defaultTranslationString: string;

  public constructor() {
    this.pattern = /[^a-zA-Z ]/g;
    this.basicText = 'Basic text';
    this.defaultTranslationString = 'default_label';
  }

  /**
   * Formats the input text by capitalizing the first letter and replacing a specified pattern.
   * @param {string | undefined} text - The input text to be formatted.
   * @returns {string} The formatted text, with the first letter capitalized and the specified pattern replaced.
   */
  public handleFormatText(text?: string | undefined): string {
    if (text && text !== undefined) {
      return (
        text.charAt(0).toUpperCase() + text.slice(1).replace(this.pattern, ' ')
      );
    } else {
      return this.basicText;
    }
  }

  /**
   * Handles translation strings by replacing hyphens with underscores.
   * @param {string | undefined} text - The input translation string that may contain hyphens.
   * @returns {string} - The processed translation string with hyphens replaced by underscores.
   */
  public handleTranslationString(text?: string | undefined): string {
    if (text && text !== undefined) {
      return text.replace('-', '_');
    } else {
      return this.defaultTranslationString;
    }
  }
}
