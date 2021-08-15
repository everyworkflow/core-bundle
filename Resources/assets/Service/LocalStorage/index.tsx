const LocalStorage = {
    get: (key: string, isJson = true): string | null => {
        if (isJson) {
            return JSON.parse(localStorage.getItem(key) ?? '');
        }
        return localStorage.getItem(key);
    },
    set: (key: string, value: string | any): void => {
        if (typeof value !== 'string') {
            value = JSON.stringify(value);
        }
        localStorage.setItem(key, value);
    },
};

export default LocalStorage;
