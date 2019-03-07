import { $request } from 'helper';

/**
 * 获取内容分类列表
 * @param {*} params 
 */
export function getContentCatList(params = {}) {
    return $request.get('/v1/content_cat/list', params)
}

/**
 * 创建内容分类
 * @param {*} params 
 */
export function createContentCat(params = {}) {
    return $request.post('/v1/content_cat/create', params)
}

/**
 * 更新内容分类
 * @param {*} params 
 */
export function updateContentCat(params = {}) {
    return $request.post('/v1/content_cat/update', params)
}

/**
 * 删除内容分类
 * @param {*} params 
 */
export function deleteContentCat(params = {}) {
    return $request.post('/v1/content_cat/delete', params)
}

/**
 * 所有内容分类记录
 * @param {*} params 
 */
export function itemsContentCat(params = {}) {
    return $request.get('/v1/content_cat/items', params)
}

/**
 * 获取内容列表
 * @param {*} params 
 */
export function getContentList(params = {}) {
    return $request.get('/v1/content/list', params);
}

/**
 * 获取内容
 * @param {*} params 
 */
export function getContentDetail(params = {}){
    return $request.get('/v1/content/detail', params);
}

/**
 * 创建内容
 * @param {*} params 
 */
export function createContent(params = {}) {
    return $request.post('/v1/content/create', params);
}

/**
 * 更新内容
 * @param {*} params 
 */
export function updateContent(params = {}) {
    return $request.post('/v1/content/update', params);
}

/**
 * 删除内容
 * @param {*} params 
 */
export function deleteContent(params = {}) {
    return $request.post('/v1/content/delete', params);
}