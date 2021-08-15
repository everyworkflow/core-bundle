const SessionStorage = {
    get: (key: string, isJson = true): string | null => {
        if (isJson) {
            return JSON.parse(sessionStorage.getItem(key) ?? '');
        }
        return sessionStorage.getItem(key);
    },
    set: (key: string, value: string | any): void => {
        if (typeof value !== 'string') {
            value = JSON.stringify(value);
        }
        sessionStorage.setItem(key, value);
    },
};

export default SessionStorage;
