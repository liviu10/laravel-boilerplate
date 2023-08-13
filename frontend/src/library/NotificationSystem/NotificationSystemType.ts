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

/**
 * Interface representing additional notification message properties.
 * @property description
 * @property message
 * @property error
 * @interface NotificationAdditionalMessageInterface
 */
interface NotificationAdditionalMessageInterface {
  description?: string | undefined
  message?: string | undefined
  error?: string | undefined
}

/**
 * Interface representing log properties.
 * @property message
 * @property response
 * @property request
 * @interface NotificationSystemLogInterface
 */
interface NotificationSystemLogInterface {
  message?: string | undefined
  response?: {
    data: {
      message: string
    }
  } | undefined
}

export {
  NotificationTypeOptions,
  NotificationIconOptions,
  NotificationPositionType,
  NotificationColorType,
  NotificationAdditionalMessageInterface,
  NotificationSystemLogInterface
}
