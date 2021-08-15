/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React, {useEffect} from 'react';
import {useHistory} from 'react-router-dom';

interface ScrollToTopOnRouteChangeProps {
    children: JSX.Element;
}

const ScrollToTopOnRouteChange = ({children}: ScrollToTopOnRouteChangeProps) => {
    const history = useHistory();

    useEffect(() => {
        return history.listen(() => {
            window.scrollTo(0, 0);
        });
    }, [history]);

    return (
        <>
            {children}
        </>
    );
};

export default ScrollToTopOnRouteChange;
