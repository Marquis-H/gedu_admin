import { $request } from 'helper';

/**
 * 获取banner列表
 * @param {*} params 
 */
export function getBannerList(params = {}) {
    return $request.get('/v1/banner/list', params)
}

/**
 * 创建banner
 * @param {*} params 
 */
export function createBanner(params = {}) {
    return $request.post('/v1/banner/create', params)
}

/**
 * 更新banner
 * @param {*} params 
 */
export function updateBanner(params = {}) {
    return $request.post('/v1/banner/update', params)
}

/**
 * 删除banner
 * @param {*} params 
 */
export function deleteBanner(params = {}) {
    return $request.post('/v1/banner/delete', params)
}