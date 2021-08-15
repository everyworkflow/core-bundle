/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React from 'react';
import {Spin} from "antd";
import {LoadingOutlined} from "@ant-design/icons";

const LoadingIndicatorComponent = () => {
    return (
        <div style={{textAlign: 'center', padding: 24}}>
            <Spin indicator={<LoadingOutlined style={{fontSize: 24}} spin/>}/>
        </div>
    );
}

export default LoadingIndicatorComponent;
