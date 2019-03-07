import { $request } from 'helper';

/**
 * 获取奖品列表
 * @param {*} params 
 */
export function getPrizeList(params = {}) {
    return $request.get('/v1/prize/list', params)
}

/**
 * 创建奖品
 * @param {*} params 
 */
export function createPrize(params = {}) {
    return $request.post('/v1/prize/create', params)
}

/**
 * 更新奖品
 * @param {*} params 
 */
export function updatePrize(params = {}) {
    return $request.post('/v1/prize/update', params)
}

/**
 * 删除奖品
 * @param {*} params 
 */
export function deletePrize(params = {}) {
    return $request.post('/v1/prize/delete', params)
}