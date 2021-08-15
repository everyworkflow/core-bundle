/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import {CSSProperties} from "react";

const StyleHelper = {
    remoteStyleParse: (style: any): CSSProperties | undefined => {
        if (typeof style === 'string' && style !== '') {
            try {
                return JSON.parse(style);
            } catch (error) {
                console.log('StyleHelper-remoteStyleParse-error', error);
            }
        } else if (typeof style === 'object') {
            return style;
        }
        return undefined;
    },
};

export default StyleHelper;
