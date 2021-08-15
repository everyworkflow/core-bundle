/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React from 'react';
import {Link} from 'react-router-dom';
import Result from "antd/lib/result";
import Button from "antd/lib/button";

const Error403Component = () => {
    return (
        <Result
            status="403"
            title="403"
            subTitle="Sorry, you are not authorized to access this page."
            extra={<Link to={'/'}><Button type="primary">Back Home</Button></Link>}
        />
    );
}

export default Error403Component;
