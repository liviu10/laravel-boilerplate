// Import vue related utilities
import { Notify } from 'quasar';
import { ref } from 'vue';

enum NotificationTypeOptions {
  positive = 'positive',
  negative = 'negative',
  warning = 'warning',
  info = 'info',
}

enum NotificationIconOptions {
  done = 'done',
  info = 'info',
  warning = 'warning',
  error = 'error',
}

type NotificationPositionType =
  | 'top-left'
  | 'top-right'
  | 'bottom-left'
  | 'bottom-right'
  | 'top'
  | 'bottom'
  | 'left'
  | 'right'
  | 'center'

type NotificationColorType =
  | 'black'
  | 'white'

interface INotificationAdditionalMessage {
  description?: string | undefined
  message?: string | undefined
  error?: string | undefined
}

interface INotificationSystemLog {
  message?: string | undefined
  response?: {
    data: {
      message: string
    }
  } | undefined
}

interface IHandleNotification {
  handleNotificationSystem: (
    title?: string,
    description?: string,
    type?: string,
    position?: NotificationPositionType,
    progress?: boolean,
    additionalMessage?: INotificationAdditionalMessage,
  ) => void;
  handleNotificationLog: (
    type: string,
    storeId: string,
    context: INotificationSystemLog
  ) => string | void
}

export class HandleNotification implements IHandleNotification {
  /**
   * Handles the creation and display of a notification in the system.
   * @param {string | undefined} title - The title of the notification.
   * @param {string | undefined} description - The description or content of the notification.
   * @param {string | undefined} type - The type of notification (e.g., success, warning, error).
   * @param {NotificationPositionType | undefined} position - The position on the screen where the notification should appear.
   * @param {boolean | undefined} progress - Indicates whether to show a progress indicator in the notification.
   * @param {INotificationAdditionalMessage | undefined} additionalMessage - Additional custom message for the notification.
   */
  public handleNotificationSystem(
    title?: string,
    description?: string,
    type?: string,
    position?: NotificationPositionType,
    progress?: boolean,
    additionalMessage?: INotificationAdditionalMessage,
  ) {
    Notify.create({
      actions: [
        { color: 'black', icon: 'close' }
      ],
      classes: this.handleNotificationClass(type),
      html: true,
      icon: this.handleNotificationIcon(type),
      message: this.handleNotificationMessage(title, description, type, additionalMessage),
      position: this.handleNotificationPosition(position),
      progress: this.handleNotificationProgress(progress),
      textColor: this.handleNotificationColor(type),
      type: this.handleNotificationType(type),
      timeout: this.handleNotificationTimeout(type),
    })
  };

  /**
   * Generates a log message for a notification based on its type, store ID, and context.
   * @param {string} type - The type of notification (e.g., info, warning, negative).
   * @param {string} storeId - The identifier of the store associated with the notification.
   * @param {INotificationSystemLog} context - Additional context information for the notification log.
   * @returns {string | void} - The formatted log message or void if the type is not recognized.
   */
  public handleNotificationLog(
    type: string, storeId: string, context: INotificationSystemLog
  ): string | void {
    switch (type) {
      case NotificationTypeOptions.info:
        return `${storeId}: ${context}`;
      case NotificationTypeOptions.warning:
        return `${storeId}: ${context}`;
      case NotificationTypeOptions.negative:
        return `${storeId}: ${context.message}. ${context.response?.data.message}`;
      default:
        return;
    }
  }

  /**
   * Determines the icon to be used for a given notification type.
   * @param {string | undefined} type - The type of notification (e.g., positive, info, warning, negative).
   * @returns {string} - The icon name associated with the specified notification type.
   */
  private handleNotificationIcon(type?: string): string {
    switch (type) {
      case NotificationTypeOptions.positive:
        return NotificationIconOptions.done;
      case NotificationTypeOptions.info:
        return NotificationIconOptions.info;
      case NotificationTypeOptions.warning:
        return NotificationIconOptions.warning;
      case NotificationTypeOptions.negative:
        return NotificationIconOptions.error;
      default:
        return NotificationIconOptions.info;
    }
  }

  /**
   * Generates a formatted notification message based on the provided parameters.
   * @param {string | undefined} title - The title of the notification.
   * @param {string | undefined} message - The main content or message of the notification.
   * @param {string | undefined} type - The type of notification (e.g., positive, info, warning, negative).
   * @param {INotificationAdditionalMessage | undefined} additionalMessage - Additional custom message for the notification.
   * @returns {string} - The formatted notification message as a string.
   */
  private handleNotificationMessage(
    title?: string,
    message?: string,
    type?: string,
    additionalMessage?: INotificationAdditionalMessage
  ): string {
    if (!message || typeof message !== 'string') {
      return 'Generic notification message!';
    }

    const commonMessage = ref('');
    const isTypePositive = NotificationTypeOptions.positive === this.handleNotificationType(type);
    const isTypeInfo = NotificationTypeOptions.info === this.handleNotificationType(type);

    if (!title || typeof title !== 'string') {
      title = 'Info';
    }

    if (isTypePositive || isTypeInfo) {
      commonMessage.value = `<p class="q-mb-none">${title}! ${message}!</p>`;
    } else {
      let additionalMessageText = '';
      if (additionalMessage && Object.keys(additionalMessage).length) {
        if (additionalMessage.description) {
          additionalMessageText = `<p class="q-mb-none">${additionalMessage.description}</p>`;
        }

        if (additionalMessage.message) {
          additionalMessageText = `<p class="q-mb-none">${additionalMessage.message}</p>`;
        }

        if (additionalMessage.error) {
          additionalMessageText = `<p class="q-mb-none">${additionalMessage.error}</p>`;
        }
      }

      commonMessage.value = `
        <p class="q-mb-none">${title}! ${message}!</p>
        <p class="q-mb-none">There was a problem in processing your request!</p>
        ${additionalMessageText}
        <p class="q-mb-none">Please try again and if the problem persist contact the administrator!</p>
      `;
    }

    return commonMessage.value;
  }

  /**
   * Determines the position on the screen where the notification should appear.
   * @param {NotificationPositionType | undefined} position - The desired position for the notification (e.g., top, bottom).
   * @returns {NotificationPositionType} - The resolved notification position, defaulting to 'bottom' if not specified.
   */
  private handleNotificationPosition(position?: NotificationPositionType): NotificationPositionType {
    return position && position !== undefined ? position : 'bottom';
  }

  /**
   * Determines whether to show a progress indicator in the notification.
   * @param {boolean | undefined} progress - Indicates whether to display a progress indicator (true or false).
   * @returns {boolean} - The resolved value for displaying a progress indicator, defaulting to true if not specified.
   */
  private handleNotificationProgress(progress?: boolean): boolean {
    return progress && progress !== undefined ? progress : true;
  }

  /**
   * Determines the type of notification (e.g., positive, info, warning, negative).
   * @param {string | undefined} type - The desired type for the notification.
   * @returns {string} - The resolved notification type, defaulting to 'info' if not specified.
   */
  private handleNotificationType(type?: string): string {
    return type && type !== undefined ? type : NotificationTypeOptions.info
  }

  /**
   * Determines the timeout duration for displaying the notification based on its type.
   * @param {string | undefined} type - The type of notification (e.g., positive, info, warning, negative).
   * @returns {number} - The resolved timeout duration in milliseconds.
   */
  private handleNotificationTimeout(type?: string): number {
    switch (type) {
      case NotificationTypeOptions.positive:
      case NotificationTypeOptions.info:
        return 5000;
      case NotificationTypeOptions.warning:
      case NotificationTypeOptions.negative:
        return 10000;
      default:
        return 5000;
    }
  }

  /**
   * Determines the CSS class for styling the notification based on its type.
   * @param {string | undefined} type - The type of notification (e.g., positive, info, warning, negative).
   * @returns {string} - The resolved CSS class for styling the notification.
   */
  private handleNotificationClass(type?: string): string {
    switch (type) {
      case NotificationTypeOptions.positive:
        return 'q-notification-positive'
      case NotificationTypeOptions.info:
        return 'q-notification-info'
      case NotificationTypeOptions.warning:
        return 'q-notification-warning'
      case NotificationTypeOptions.negative:
        return 'q-notification-negative'
      default:
        return 'q-notification-generic'
    }
  }

  /**
   * Determines the text color for the notification based on its type.
   * @param {string | undefined} type - The type of notification (e.g., positive, info, warning, negative).
   * @returns {NotificationColorType} - The resolved text color for the notification.
   */
  private handleNotificationColor(type?: string): NotificationColorType {
    switch (type) {
      case NotificationTypeOptions.positive:
      case NotificationTypeOptions.warning:
      case NotificationTypeOptions.info:
        return 'black';
      case NotificationTypeOptions.negative:
        return 'white';
      default:
        return 'black';
    }
  }
}
