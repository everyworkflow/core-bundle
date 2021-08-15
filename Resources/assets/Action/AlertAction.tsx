/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import notification from "antd/lib/notification";
import AlertDataInterface from "@EveryWorkflow/CoreBundle/Model/AlertDataInterface";

export const ALERT_TYPE_DEFAULT = 'alert_type_default'; // default
export const ALERT_TYPE_SUCCESS = 'alert_type_success';
export const ALERT_TYPE_ERROR = 'alert_type_error';
export const ALERT_TYPE_INFO = 'alert_type_info';
export const ALERT_TYPE_WARNING = 'alert_type_warning';

const ALERT_PLACEMENT = 'topRight';

const AlertAction = (alertData: AlertDataInterface) => {
    switch (alertData.type) {
        case ALERT_TYPE_SUCCESS: {
            notification.success({
                placement: ALERT_PLACEMENT,
                message: alertData.title,
                description: alertData.message,
                onClick: () => {
                    console.log('Notification Clicked!');
                },
            });
            break;
        }
        case ALERT_TYPE_ERROR: {
            notification.error({
                placement: ALERT_PLACEMENT,
                message: alertData.title,
                description: alertData.message,
                onClick: () => {
                    console.log('Notification Clicked!');
                },
            });
            break;
        }
        case ALERT_TYPE_INFO: {
            notification.info({
                placement: ALERT_PLACEMENT,
                message: alertData.title,
                description: alertData.message,
                onClick: () => {
                    console.log('Notification Clicked!');
                },
            });
            break;
        }
        case ALERT_TYPE_WARNING: {
            notification.warning({
                placement: ALERT_PLACEMENT,
                message: alertData.title,
                description: alertData.message,
                onClick: () => {
                    console.log('Notification Clicked!');
                },
            });
            break;
        }
        default: {
            notification.open({
                placement: ALERT_PLACEMENT,
                message: alertData.title,
                description: alertData.message,
                onClick: () => {
                    console.log('Notification Clicked!');
                },
            });
        }
    }
}

export default AlertAction;
