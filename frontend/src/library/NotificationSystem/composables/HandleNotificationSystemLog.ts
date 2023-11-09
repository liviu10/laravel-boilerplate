import { computed } from 'vue';
import {
  NotificationTypeOptions,
  INotificationSystemLog
} from './HandleNotificationSystemType';

/**
 * Handle the notification system log based on the provided type, store ID, and context.
 * @param {string} type - The type of notification (e.g., 'info', 'warning', 'negative').
 * @param {string} storeId - The store identifier associated with the log.
 * @param {INotificationSystemLog} context - The context information for the log.
 * @returns {string | void} A formatted log message based on the type and context, or void if the type is not recognized.
 */
const handleNotificationSystemLog = computed(() => {
  return ((type: string, storeId: string, context: INotificationSystemLog): string | void => {
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
  });
});

export { handleNotificationSystemLog }
