const LocalStorage = {
    get: (key: string, isJson = true): string | null => {
        if (isJson) {
            try {
                const jsonData = JSON.parse(localStorage.getItem(key) ?? '');
                return jsonData;
            } catch (error: any) {
                // Ignore error is unable to parse data
            }

            return null;
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
