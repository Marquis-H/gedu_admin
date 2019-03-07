import { $request } from 'helper';

/**
 * 登陆
 * @param {*} params
 */
export function login(params = {}) {
    return $request.post('/v1/auth/login_check', params);
}

/**
 * 登出
 * @param {*} params 
 */
export function logout(params = {}) {
    return $request.post('/v1/auth/logout', params);
}