interface IHandleEnv {
  handleApplicationName: () => string;
  handleContactUrl: () => string;
  handleCopyrightText: () => string;
  handleDesignerName: () => string;
  handleApplicationVersion: () => string;
}

export class HandleEnv implements IHandleEnv {
  applicationName?: string
  defaultApplicationName: string
  contactUrl?: string
  startingYear: number
  currentYear: number
  designerName?: string
  defaultDesignerName: string
  applicationVersion?: string
  defaultApplicationVersion: string

  public constructor() {
    this.applicationName = undefined
    this.defaultApplicationName = 'Generic dashboard'
    this.contactUrl = undefined
    this.startingYear = 2023
    this.currentYear = new Date().getFullYear()
    this.designerName = undefined
    this.defaultDesignerName = 'John Doe'
    this.applicationVersion = undefined
    this.defaultApplicationVersion = 'v1.0'
  }

  /**
   * Handles the retrieval of the application name, either from the environment variable
   * or using the default application name if the environment variable is not set.
   * @returns {string} - The resolved application name.
   */
  public handleApplicationName(): string {
    this.applicationName = process.env.APP_NAME ?? this.defaultApplicationName

    return this.applicationName
  }

  /**
   * Handles the retrieval of the contact URL, either from the environment variable
   * or using a default value ('#') if the environment variable is not set.
   * @returns {string} - The resolved contact URL.
   */
  public handleContactUrl(): string {
    this.contactUrl = process.env.APP_DESIGNER_URL ?? '#'

    return this.contactUrl
  }

  /**
   * Handles the generation of the copyright text based on the current year and starting year.
   * @returns {string} - The resolved copyright text.
   */
  public handleCopyrightText(): string {
    if (this.currentYear > this.startingYear) {
      return `Copyright © ${this.startingYear} — ${this.currentYear} All rights reserved`
    } else {
      return `Copyright © ${this.currentYear} All rights reserved`
    }
  }

  /**
   * Handles the retrieval of the designer name, either from the environment variable
   * or using the default designer name if the environment variable is not set.
   * @returns {string} - The resolved designer name.
   */
  public handleDesignerName(): string {
    this.designerName = process.env.APP_DESIGNER ?? this.defaultDesignerName

    return this.designerName
  };

  /**
   * Handles the retrieval of the application version, either from the environment variable
   * or using the default application version if the environment variable is not set.
   * @returns {string} - The resolved application version.
   */
  public handleApplicationVersion(): string {
    this.applicationVersion = process.env.APP_VERSION ?? this.defaultApplicationVersion

    return this.applicationVersion
  };
}
