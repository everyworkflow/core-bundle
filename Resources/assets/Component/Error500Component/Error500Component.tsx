/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React from 'react';
import {Link} from 'react-router-dom';
import Result from "antd/lib/result";
import Button from "antd/lib/button";

const Error500Component = () => {
    return (
        <Result
            status="500"
            title="500"
            subTitle="Sorry, something went wrong."
            extra={<Link to={'/'}><Button type="primary">Back Home</Button></Link>}
        />
    );
}

export default Error500Component;
