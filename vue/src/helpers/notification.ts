import { AxiosError } from 'axios';
import { Notify, QSpinnerGears } from 'quasar';
/**
 * @class Notification Helper
 */
class NotificationHelper {
  private _loading: CallableFunction | undefined;

  /**
   * Handle Axios Error
   * @param _error
   */
  axiosError(_error: unknown) {
    const error = _error as AxiosError;
    console.log('Axios Error', error.response?.data);
    this.error('Se ha producido un error');
  }
  /**
   * error
   * @param message
   */
  error(message: string) {
    Notify.create({
      color: 'negative',
      message: message,
      position: 'center',
      icon: 'mdi-alert',
    });
  }

  /**
   * loading
   * @param _load
   * @param message
   */
  loading(
    _load = true,
    message = 'Cargando...',
    timeout = 0,
    position:
      | 'top-left'
      | 'top-right'
      | 'bottom-left'
      | 'bottom-right'
      | 'top'
      | 'bottom'
      | 'left'
      | 'right'
      | 'center' = 'center'
  ) {
    if (_load) {
      this._loading = Notify.create({
        spinner: QSpinnerGears,
        position,
        message,
        timeout,
      });
    } else {
      if (this._loading) this._loading();
    }
  }
  /**
   * Success
   * @param message
   */
  success(message: string) {
    Notify.create({
      color: 'positive',
      message: message,
      position: 'center',
      icon: 'mdi-check',
    });
  }
}

/**
 * Notification Helper
 */
export const $notificationHelper = new NotificationHelper();
