/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React, {Suspense} from 'react';
import RouteItemInterface from "@EveryWorkflow/CoreBundle/Model/RouteItemInterface";
import Error404Component from "@EveryWorkflow/CoreBundle/Component/Error404Component";
import {Route, Switch} from "react-router-dom";
import LoadingIndicatorComponent from "@EveryWorkflow/CoreBundle/Component/LoadingIndicatorComponent";

interface RouteMapRenderComponentProps {
    routeMaps: Array<any>;
}

const RouteMapRenderComponent = ({routeMaps}: RouteMapRenderComponentProps) => {
    const routeList: Array<RouteItemInterface> = [];
    routeMaps.forEach(routes => {
        routes.map((routeItem: RouteItemInterface) => {
            routeList.push(routeItem);
        });
    });
    routeList.push({
        component: Error404Component,
        path: '*'
    });

    return (
        <Suspense fallback={<LoadingIndicatorComponent/>}>
            <Switch>
                {routeList.map((route, index) => (
                    <Route key={index} path={route.path} exact={route.exact} component={route.component}/>
                ))}
            </Switch>
        </Suspense>
    );
};

export default RouteMapRenderComponent;
