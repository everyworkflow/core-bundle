/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import ResponseResolver from './ResponseResolver';
import UrlHelper from "@EveryWorkflow/CoreBundle/Helper/UrlHelper";

const PostRequest = async (endPoint: string, data: any | Array<any>) => {
    const url = UrlHelper.buildApiUrl(endPoint);

    const fetchOptions = {
        method: 'post',
        body: JSON.stringify(data),
    };

    if (Number(process.env.REACT_DEBUG) && Number(process.env.REACT_REMOTE_DEBUG) > 0) {
        console.log('remote post -> ' + url, fetchOptions);
    }

    const res = await fetch(url, fetchOptions);

    if (Number(process.env.REACT_DEBUG) && Number(process.env.REACT_REMOTE_DEBUG) > 1) {
        console.log('remote post response -> ' + url, res);
    }

    return ResponseResolver(res, url);
};

export default PostRequest;
