type TColor = 'primary' | 'secondary' | 'accent' | 'dark' | 'positive' | 'negative' | 'info' | 'warning'

interface IHandleColor {
  handleTextColor: (textColor?: TColor | undefined) => string
}

export class HandleColor implements IHandleColor {
  colors: { [key: number]: TColor }

  public constructor() {
    this.colors = {
      0: 'primary',
      1: 'secondary',
      2: 'accent',
      3: 'dark',
      4: 'positive',
      5: 'negative',
      6: 'info',
      7: 'warning',
    }
  }

  /**
   * Determines the appropriate text color based on the provided color parameter.
   * @param {TColor | undefined} color - The color value to be used for determining text color.
   * Possible values include: 'primary', 'accent', 'dark', 'negative', 'secondary',
   * 'positive', 'info', 'warning', or undefined for default.
   * @returns {string} The CSS style for text color corresponding to the input color.
   * Returns 'color: #FFFFFF' for 'primary', 'accent', 'dark', and 'negative'.
   * Returns 'color: #000000' for 'secondary', 'positive', 'info', 'warning', and default.
   */
  public handleTextColor(color?: TColor | undefined): string {
    switch (color) {
      case 'primary':
      case 'accent':
      case 'dark':
      case 'negative':
        return 'color: #FFFFFF'
      case 'secondary':
      case 'positive':
      case 'info':
      case 'warning':
        return 'color: #000000'
      default:
        return 'color: #000000'
    }
  }
}
