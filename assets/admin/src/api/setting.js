import { $request } from 'helper';

/**
 * 获取设定
 * @param {*} params
 */
export function getSetting(params = {}) {
    return $request.get('/v1/setting/detail', params);
}

/**
 * 创建设定
 * @param {*} params 
 * @param {*} identify 
 */
export function createSetting(params = {}, identify = null) {
    return $request.post('/v1/setting/create?identify=' + identify, params);
}