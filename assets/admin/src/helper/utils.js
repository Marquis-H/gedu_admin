export default {
    queryString(url, query) {
        let str = [];
        for (let key in query) {
            if (typeof query[key] == 'object') {
                str.push(key + '=' + JSON.stringify(query[key]));
            } else {
                str.push(key + '=' + query[key]);
            }
        }
        let paramStr = str.join('&');
        return paramStr ? `${url}?${paramStr}` : url;
    },

    lanToISO639(lang) {
        switch (lang) {
            case 'cn':
                return 'zh';
            case 'en':
                return 'en';
            default:
                return lang;
        }
    }
};
