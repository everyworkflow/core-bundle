/*
 * @copyright EveryWorkflow. All rights reserved.
 */

const UrlHelper = {
    buildApiUrl: (url: string): string => {
        if (!url.startsWith('https://') && !url.startsWith('http://') &&
            process.env.API_END_POINT && !url.startsWith(process.env.API_END_POINT)) {
            url = process.env.API_END_POINT + url;
        }
        if (!url.startsWith('https://') && !url.startsWith('http://') &&
            process.env.API_BASE_URL && !url.startsWith(process.env.API_BASE_URL)) {
            url = process.env.API_BASE_URL + url;
        }
        return url;
    },

    buildImgUrlFromPath: (path: string | null | undefined): string => {
        if (path === null || path === undefined) {
            return '';
        }
        if (path.startsWith('http://') || path.startsWith('https://')) {
            return path;
        }
        return process.env.MEDIA_BASE_URL + path;
    },
};

export default UrlHelper;
