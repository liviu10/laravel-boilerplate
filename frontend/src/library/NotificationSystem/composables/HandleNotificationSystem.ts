// Import vue related utilities
import { Notify } from 'quasar';
import { computed, ref } from 'vue';

// Import generic components, libraries and interfaces
import {
  NotificationTypeOptions,
  NotificationIconOptions,
  NotificationPositionType,
  NotificationColorType,
  INotificationAdditionalMessage
} from './HandleNotificationSystemType';

/**
 * Creates and displays a notification using the Quasar framework's Notify.create method.
 * @param {title} title - The title of the notification.
 * @param {description} description - The description or main content of the notification.
 * @param {type} type - The type of notification (e.g., 'positive', 'error', 'warning').
 * @param {position} position - The position of the notification on the screen.
 * @param {progress} progress - (Optional) If true, shows a progress indicator for the notification.
 * @param {additionalMessage} additionalMessage - (Optional) Additional message or details for the notification.
 * @returns {void}
 */
const handleNotificationSystem = (
  title: string | undefined,
  description: string | undefined,
  type: string | undefined,
  position: NotificationPositionType | undefined,
  progress?: boolean | undefined,
  additionalMessage?: INotificationAdditionalMessage | undefined,
) =>
  Notify.create({
    html: true,
    icon: notificationIcon.value(type),
    message: notificationMessage.value(title, description, type, additionalMessage),
    position: notificationPosition.value(position),
    progress: notificationProgress.value(progress),
    textColor: notificationColor.value(type),
    type: notificationType.value(type),
    timeout: notificationTimeout.value(type),
    classes: notificationClasses.value(type)
  })

  /**
   * Computed function to get the icon associated with the given notification type.
   * @param {type} type - The type of the notification (e.g., 'positive', 'info', 'warning', 'negative').
   * @returns {string} The icon string associated with the notification type.
   */
  const notificationIcon = computed(() => {
    return (type: string | undefined): string => {
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
  })

  /**
   * Computed function to generate the content of a notification message.
   * @param {title} title - The title of the notification.
   * @param {message} message - The main content of the notification.
   * @param {additionalMessage} additionalMessage - (Optional) Additional message or details for the notification.
   * @returns {string} The HTML-formatted notification message content.
   */
  const notificationMessage = computed(() => {
    return (
      title: string | undefined,
      message: string | undefined,
      type: string | undefined,
      additionalMessage?: INotificationAdditionalMessage | undefined
    ): string => {
      if (!message || typeof message !== 'string') {
        return 'Generic notification message!';
      }

      const commonMessage = ref('');
      const isTypePositive = NotificationTypeOptions.positive === notificationType.value(type);
      const isTypeInfo = NotificationTypeOptions.info === notificationType.value(type);

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
    };
  });

  /**
   * Computed function to determine the position of a notification on the screen.
   * @param {position} position - The desired position of the notification (e.g., 'top', 'bottom', 'left', 'right').
   * @returns {Type<NotificationPositionType>} The resolved position for the notification.
   */
  const notificationPosition = computed(() => {
    return (position: NotificationPositionType | undefined): NotificationPositionType => {
      return position && position !== undefined ? position : 'bottom';
    }
  })

  /**
   * Computed function to determine whether to show a progress indicator in a notification.
   * @param {progress} progress - (Optional) If true, the notification will display a progress indicator.
   * @returns {boolean} The resolved value for displaying a progress indicator.
   */
  const notificationProgress = computed(() => {
    return (progress: boolean | undefined): boolean => {
      return progress && progress !== undefined ? progress : true;
    }
  })

  /**
   * Computed function to determine the type of a notification.
   * @param {type} type - The type of the notification (e.g., 'positive', 'info', 'warning', 'negative').
   * @returns {string} The resolved type for the notification.
   */
  const notificationType = computed(() => {
    return (type: string | undefined): string => {
      return type && type !== undefined ? type : NotificationTypeOptions.info
    }
  })

  /**
   * Computed function to determine the timeout duration for a notification.
   * @param {type} type - The type of the notification (e.g., 'positive', 'info', 'warning', 'negative').
   * @returns {number} The resolved timeout duration in milliseconds for the notification.
   */
  const notificationTimeout = computed(() => {
    return (type: string | undefined): number => {
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
  })

  /**
   * Computed function to determine the CSS classes for styling a notification based on its type.
   * @param {type} type - The type of the notification (e.g., 'positive', 'info', 'warning', 'negative').
   * @returns {string} The CSS class names associated with the notification type.
   */
  const notificationClasses = computed(() => {
    return (type: string | undefined): string => {
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
  })

  /**
   * Computed function to determine the color type for styling a notification based on its type.
   * @param {type} type - The type of the notification (e.g., 'positive', 'info', 'warning', 'negative').
   * @returns {Type<NotificationColorType>} The color type associated with the notification type.
   */
  const notificationColor = computed(() => {
    return (type: string | undefined): NotificationColorType => {
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
  })

export { handleNotificationSystem };
