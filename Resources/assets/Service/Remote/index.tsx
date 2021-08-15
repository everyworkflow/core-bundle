/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import GetRequest from "@EveryWorkflow/CoreBundle/Service/Remote/GetRequest";
import PostRequest from "@EveryWorkflow/CoreBundle/Service/Remote/PostRequest";

const Remote = {
    get: GetRequest,
    post: PostRequest,
};

export default Remote;
