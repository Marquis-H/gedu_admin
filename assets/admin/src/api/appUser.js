import { $request } from 'helper';

/**
 * 获取用户列表
 * @param {*} params 
 */
export function getUserList(params = {}) {
    return $request.get('/v1/app_user/list', params)
}

/**
 * 创建用户
 * @param {*} params 
 */
export function createUser(params = {}) {
    return $request.post('/v1/app_user/create', params)
}

/**
 * 更新用户
 * @param {*} params 
 */
export function updateUser(params = {}) {
    return $request.post('/v1/app_user/update', params)
}

/**
 * 删除用户
 * @param {*} params 
 */
export function deleteUser(params = {}) {
    return $request.post('/v1/app_user/delete', params)
}

/**
 * 更新积分
 * @param {*} params 
 */
export function updateIntegral(params = {}) {
    return $request.post('/v1/app_user/update_integral', params)
}