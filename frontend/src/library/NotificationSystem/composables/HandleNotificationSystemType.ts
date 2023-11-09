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

export {
  NotificationTypeOptions,
  NotificationIconOptions,
  NotificationPositionType,
  NotificationColorType,
  INotificationAdditionalMessage,
  INotificationSystemLog
}
