import { $request } from 'helper';

/**
 * 获取页面列表
 * @param {*} params 
 */
export function getPageList(params = {}) {
    return $request.get('/v1/page/list', params);
}

/**
 * 获取页面内容
 * @param {*} params 
 */
export function getPageDetail(params = {}){
    return $request.get('/v1/page/detail', params);
}

/**
 * 创建页面
 * @param {*} params 
 */
export function createPage(params = {}) {
    return $request.post('/v1/page/create', params);
}

/**
 * 更新页面
 * @param {*} params 
 */
export function updatePage(params = {}) {
    return $request.post('/v1/page/update', params);
}

/**
 * 删除页面
 * @param {*} params 
 */
export function deletePage(params = {}) {
    return $request.post('/v1/page/delete', params);
}