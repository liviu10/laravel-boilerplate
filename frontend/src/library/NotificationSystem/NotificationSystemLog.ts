import { computed } from 'vue';
import {
  NotificationTypeOptions,
  NotificationSystemLogInterface
} from './NotificationSystemType';

const notificationSystemLog = computed(() => {
  return ((type: string, storeId: string, context: NotificationSystemLogInterface): string | void => {
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

export {
  notificationSystemLog
}
