import axios from 'axios';
// eslint-disable-next-line
import { $utils } from 'helper';
// eslint-disable-next-line
import $q from 'q';
import { i18n } from '../common';
import { getToken } from './auth';
import router from '../router';
import { Message } from 'element-ui';

const codeMessage = {
    'Bad credentials': '无法登入，请检查账户或密码',
    'Login timeout': '登录超时',
    'Error': '出错！请刷新页面'
};

function requestHandle(options = {}) {
    const defer = $q.defer();

    // 判断是否有token
    if (getToken() !== null) {
        // 带上token请求api
        options.headers = {
            Authorization: `Bearer ${getToken()}`,
            ...options.headers,
        };
    }
    axios(options)
        .then((res) => {
            if (res.status === 200) {
                const data = res.data;
                if (data.code === 0 || data.code === undefined || data.code === 100) {
                    defer.resolve(data);
                } else if (data.code === 401) {
                    // 登出
                    Message.error(codeMessage['Login timeout'])
                    router.push({ path: '/logout' })
                    defer.reject(data);
                } else {
                    //无法登入，检查账号密码
                    Message.error(codeMessage[data.message])
                    defer.reject(data);
                }
            } else if (res.status === 401) {
                // 登出
                Message.error(codeMessage['Login timeout'])
                router.push({ path: '/logout' })
                defer.reject(i18n.t('serverError'));
            } else {
                Message.error(codeMessage['Error'])
                defer.reject(i18n.t('serverError'));
            }
        })
        .catch(e => {
            // 访问API出错
            Message.error(codeMessage['Error'])
            defer.reject(i18n.t('serverError'));
        });
    return defer.promise;
}

/**
 * 请求参数默认添加语言
 * @param {*} params
 */
function beforeRequest() {
    // 如果已经指定语言则不添加
    // if (!('lang' in params)) {
    //     params.lang = i18n.locale;
    // }
}

export default {
    post(url, params) {
        beforeRequest(params);
        return requestHandle({
            method: 'post',
            url,
            data: params,
            transformRequest: [
                (data) => {
                    let ret = '';
                    // eslint-disable-next-line
                    for (const it in data) {
                        ret += `${encodeURIComponent(it)}=${encodeURIComponent(data[it])}&`;
                    }
                    return ret;
                },
            ],
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        });
    },
    get(url, params) {
        // console.log("url: " + url + JSON.stringify(params));
        beforeRequest(params);
        return requestHandle({
            mathod: 'get',
            url: $utils.queryString(url, params),
        });
    },
};
