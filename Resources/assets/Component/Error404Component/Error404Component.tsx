/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React from 'react';
import {Link} from 'react-router-dom';
import Result from "antd/lib/result";
import Button from "antd/lib/button";

const Error404Component = () => {
    return (
        <Result
            status="404"
            title="404"
            subTitle="Sorry, the page you visited does not exist."
            extra={<Link to={'/'}><Button type="primary">Back Home</Button></Link>}
        />
    );
}

export default Error404Component;
