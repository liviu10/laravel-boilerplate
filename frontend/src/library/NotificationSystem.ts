import { Notify } from 'quasar';

/**
 * Creates a notification using the Quasar Notify component
 * @param notificationTitle - The title (string) of the error message (optional)
 * @param notificationDescription - The error message (string or array of strings)
 * or a map of error messages with their respective keys (optional)
 * @param notificationType - The type of the notification to display.
 * The acceptable values are: positive, negative, warning, info and ongoing
 * @param notificationAdditionalMessage - Additional notification message (optional)
 * that is returned by the api response
 * @returns void
 */
const notificationSystem = (
  notificationTitle: string | undefined,
  notificationDescription: string | undefined,
  notificationType: 'positive' | 'negative' | 'warning' | 'info' | 'ongoing',
  notificationAdditionalMessage?: { error: string } | undefined,
) =>
  Notify.create({
    html: true,
    icon: displayNotificationIcon(notificationType),
    message: displayNotificationMessage(notificationTitle, notificationDescription, notificationType, notificationAdditionalMessage),
    position: 'bottom',
    progress: true,
    textColor: displayNotificationColor(notificationType),
    type: notificationType,
    timeout: notificationType !== 'positive' && notificationType !== 'info' ? 10000 : 5000,
    classes: notificationType !== 'positive' && notificationType !== 'info' ? 'q-notification-error' : ''
  })

  /**
   * Returns the icon to display for the given notification type
   * @param notificationType - The type of the notification (string)
   * @returns string
   */
  function displayNotificationIcon(notificationType: string): string {
    switch (notificationType) {
      case 'positive':
        return 'done';
      case 'info':
        return 'info';
      case 'warning':
        return 'warning';
      case 'negative':
        return 'error';
      default:
        return '';
    }
  }

  /**
   * Returns the message to display for the given error title and description
   * @param notificationTitle - The title (string) of the error message (optional)
   * @param notificationDescription - The error message (string or array of strings)
   * or a map of error messages with their respective keys (optional)
   * @param notificationType - The type of the notification to display.
   * The acceptable values are: positive, negative, warning, info and ongoing
   * @param notificationAdditionalMessage - Additional message information (string)
   * that is returned by the backend (optional)
   * @returns string
   */
  function displayNotificationMessage(
    notificationTitle: string | undefined,
    notificationDescription: { [key: string]: string } | string | undefined,
    notificationType: 'positive' | 'negative' | 'warning' | 'info' | 'ongoing',
    notificationAdditionalMessage?: { error: string } | undefined,
  ): string {
    if (notificationDescription && typeof notificationDescription !== 'string') {
      let listItems = '';
      for (const key in notificationDescription) {
        listItems += `<p class="q-mb-none">${notificationDescription[key][0].replace(/</g, '&lt;').replace(/>/g, '&gt;')}</p>`;
      }
      return `
        <p class="q-mb-none">${notificationTitle}</p>
        ${listItems}
      `;
    } else if (typeof notificationDescription === 'string') {
      const commonMessage = `
        <p class="q-mb-none">${notificationTitle}! ${notificationDescription}!</p>
        <p class="q-mb-none">${notificationAdditionalMessage ? notificationAdditionalMessage?.error : ''}</p>
      `;
      if (notificationType === 'positive' || notificationType === 'info') {
        return commonMessage;
      } else {
        return commonMessage + `
          <p class="q-mb-none">Please try again and if the problem persist contact the administrator!</p>
        `;
      }
    } else if (notificationTitle) {
      return `
        <p class="q-mb-none">${notificationTitle}</p>
      `;
    } else {
      return 'Something went wrong! Please try again!';
    }
  }

  /**
   * Returns the color to use for the text of the notification based on the notification type
   * @param notificationType - The type of the notification (string)
   * @returns string
   */
  function displayNotificationColor(notificationType: string): string {
    switch (notificationType) {
      case 'positive':
      case 'warning':
      case 'info':
        return 'black';
      case 'negative':
        return 'white';
      default:
        return '';
    }
  }

export { notificationSystem };
