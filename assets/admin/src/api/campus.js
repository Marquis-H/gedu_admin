import { $request } from 'helper';

/**
 * 获取校区列表
 * @param {*} params 
 */
export function getCampusList(params = {}) {
    return $request.get('/v1/campus/list', params)
}

/**
 * 创建校区
 * @param {*} params 
 */
export function createCampus(params = {}) {
    return $request.post('/v1/campus/create', params)
}

/**
 * 更新校区
 * @param {*} params 
 */
export function updateCampus(params = {}) {
    return $request.post('/v1/campus/update', params)
}

/**
 * 删除校区
 * @param {*} params 
 */
export function deleteCampus(params = {}) {
    return $request.post('/v1/campus/delete', params)
}

/**
 * 所有记录
 * @param {*} params 
 */
export function itemsCampus(params = {}) {
    return $request.get('/v1/campus/items', params)
}
