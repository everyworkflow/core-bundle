/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import ResponseResolver from "@EveryWorkflow/CoreBundle/Service/Remote/ResponseResolver";
import UrlHelper from "@EveryWorkflow/CoreBundle/Helper/UrlHelper";

const GetRequest = async (endPoint: string) => {
    const url = UrlHelper.buildApiUrl(endPoint);

    if (Number(process.env.REACT_DEBUG) && Number(process.env.REACT_REMOTE_DEBUG) > 0) {
        console.log('remote get -> ' + url);
    }

    const res = await fetch(url);

    if (Number(process.env.REACT_DEBUG) && Number(process.env.REACT_REMOTE_DEBUG) > 1) {
        console.log('remote get response -> ' + url, res);
    }

    return ResponseResolver(res, url);
};

export default GetRequest;
