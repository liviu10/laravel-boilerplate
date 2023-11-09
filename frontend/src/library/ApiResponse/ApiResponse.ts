import { AxiosResponse } from 'axios';
import {
  handleNotificationSystem,
  handleNotificationSystemLog
} from 'src/library/NotificationSystem/main';
import { INotificationSystemLog } from '../NotificationSystem/composables/HandleNotificationSystemType';

interface IHandleApiResponse {
  handleApiResponse: (response: AxiosResponse, storeId: string) => unknown
}

export class HandleApiResponse implements IHandleApiResponse {
  notificationTitle: string | undefined
  notificationMessage: string | undefined
  notificationContext: INotificationSystemLog | undefined

  /**
   * Handles the response from an Axios request to an API.
   * @param {AxiosResponse} response - The Axios response object from the API request.
   * @param {string} storeId - The identifier of the store or context associated with the request.
   * @returns {boolean} Returns `true` if the response indicates success, and `false` otherwise.
   */
  public handleApiResponse(response: AxiosResponse, storeId: string): boolean | AxiosResponse {
    if (response && Object.keys(response).length) {
      if (response.status >= 100 && response.status <= 299) {
        if (response.data && Object.keys(response.data).length) {
          this.notificationTitle = 'Info'
          this.notificationMessage = 'Your request did not returned any records'
          this.notificationContext = {
            message: this.notificationMessage,
            response: {
              data: {
                message: `Your request did not returned any records from the database ${response.data}`
              }
            }
          }
          this.handleInfoNotification(storeId, this.notificationTitle, this.notificationMessage, this.notificationContext)
          return response;
        } else {
          this.notificationTitle = 'Info'
          this.notificationMessage = 'Your request did not returned any records'
          this.notificationContext = {
            message: this.notificationMessage,
            response: {
              data: {
                message: `Your request did not returned any records from the database ${response.data}`
              }
            }
          }
          this.handleInfoNotification(storeId, this.notificationTitle, this.notificationMessage, this.notificationContext)
          return false;
        }
      } else if (response.status >= 400 && response.status <= 499) {
        this.notificationTitle = 'Warning'
        this.notificationMessage = 'An error occurred due to your request'
        this.notificationContext = {
          message: this.notificationMessage,
          response: {
            data: {
              message: `There is a problem in processing your request. ${response.data}`
            }
          }
        }
        this.handleWarningNotification(storeId, this.notificationTitle, this.notificationMessage, this.notificationContext)
        return false;
      } else if (response.status >= 500 && response.status <= 599) {
        this.notificationTitle = 'Error'
        this.notificationMessage = 'An error occurred due to your request'
        this.notificationContext = {
          message: this.notificationMessage,
          response: {
            data: {
              message: `There is a problem in processing your request. ${response.data}`
            }
          }
        }
        this.handleErrorNotification(storeId, this.notificationTitle, this.notificationMessage, this.notificationContext)
        return false;
      } else {
        this.notificationTitle = 'Error'
        this.notificationMessage = 'Your request could not be processed'
        this.notificationContext = {
          message: this.notificationMessage,
          response: {
            data: {
              message: `There is a problem in processing your request. The response that was received from the API does not have a valid status code ${response.status}`
            }
          }
        }
        this.handleErrorNotification(storeId, this.notificationTitle, this.notificationMessage, this.notificationContext)
        return false;
      }
    } else {
      this.notificationTitle = 'Error'
      this.notificationMessage = 'Your request could not be processed'
      this.notificationContext = {
        message: this.notificationMessage,
        response: {
          data: {
            message: `There is a problem in processing your request. The response that was received from the API does not have a valid status code ${response}`
          }
        }
      }
      this.handleErrorNotification(storeId, this.notificationTitle, this.notificationMessage, this.notificationContext)
      return false;
    }
  }

  /**
   * Handles and displays an informational notification using the notification system.
   * @param {string} storeId - The identifier of the store or context associated with the notification.
   * @param {string} notificationTitle - The title of the informational notification.
   * @param {string} notificationMessage - The message content of the informational notification.
   * @param {INotificationSystemLog} notificationContext - Additional context data for the notification.
   */
  private handleInfoNotification(
    storeId: string,
    notificationTitle: string,
    notificationMessage: string,
    notificationContext: INotificationSystemLog
  ) {
    handleNotificationSystem(
      notificationTitle,
      notificationMessage,
      'warning',
      'bottom',
      true
    );
    console.warn(`${handleNotificationSystemLog.value('warning', storeId, notificationContext)}`);
  }

  /**
   * Handles and displays a warning notification using the notification system.
   * @param {string} storeId - The identifier of the store or context associated with the notification.
   * @param {string} notificationTitle - The title of the warning notification.
   * @param {string} notificationMessage - The message content of the warning notification.
   * @param {INotificationSystemLog} notificationContext - Additional context data for the warning notification.
   */
  private handleWarningNotification(
    storeId: string,
    notificationTitle: string,
    notificationMessage: string,
    notificationContext: INotificationSystemLog
  ) {
    handleNotificationSystem(
      notificationTitle,
      notificationMessage,
      'warning',
      'bottom',
      true
    );
    console.warn(`${handleNotificationSystemLog.value('warning', storeId, notificationContext)}`);
  }

  /**
   * Handles and displays an error notification using the notification system.
   * @param {string} storeId - The identifier of the store or context associated with the notification.
   * @param {string} notificationTitle - The title of the error notification.
   * @param {string} notificationMessage - The message content of the error notification.
   * @param {INotificationSystemLog} notificationContext - Additional context data for the error notification.
   */
  private handleErrorNotification(
    storeId: string,
    notificationTitle: string,
    notificationMessage: string,
    notificationContext: INotificationSystemLog
  ) {
    handleNotificationSystem(
      notificationTitle,
      notificationMessage,
      'negative',
      'bottom',
      true
    );
    console.error(`${handleNotificationSystemLog.value('negative', storeId, notificationContext)}`);
  }
}
