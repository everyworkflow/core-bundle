/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import {useState, useEffect} from 'react';

const WindowDimensions = () => {
    const hasWindow = typeof window !== 'undefined';

    function getWindowDimensions() {
        const width = hasWindow ? window.innerWidth : null;
        const height = hasWindow ? window.innerHeight : null;
        return {
            width,
            height,
        };
    }

    const [windowDimensions, setWindowDimensions] = useState(
        getWindowDimensions()
    );

    useEffect(() => {
        if (hasWindow) {
            const getWindowDimensions2 = () => {
                const width = hasWindow ? window.innerWidth : 0;
                const height = hasWindow ? window.innerHeight : 0;
                return {
                    width,
                    height,
                };
            };

            const handleResize = () => {
                setWindowDimensions(getWindowDimensions2());
            };

            window.addEventListener('resize', handleResize);
            return () => window.removeEventListener('resize', handleResize);
        }
    }, [hasWindow]);

    return windowDimensions;
}

export default WindowDimensions;
