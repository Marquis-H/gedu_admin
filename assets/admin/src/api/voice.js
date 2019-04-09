import { $request } from 'helper';

/**
 * 获取音频分类列表
 * @param {*} params 
 */
export function getVoiceCatList(params = {}) {
    return $request.get('/v1/voice_cat/list', params)
}

/**
 * 创建音频分类
 * @param {*} params 
 */
export function createVoiceCat(params = {}) {
    return $request.post('/v1/voice_cat/create', params)
}

/**
 * 更新音频分类
 * @param {*} params 
 */
export function updateVoiceCat(params = {}) {
    return $request.post('/v1/voice_cat/update', params)
}

/**
 * 删除音频分类
 * @param {*} params 
 */
export function deleteVoiceCat(params = {}) {
    return $request.post('/v1/voice_cat/delete', params)
}

/**
 * 所有音频分类记录
 * @param {*} params 
 */
export function itemsVoiceCat(params = {}) {
    return $request.get('/v1/voice_cat/items', params)
}

/**
 * 获取音频列表
 * @param {*} params 
 */
export function getVoiceList(params = {}) {
    return $request.get('/v1/voice/list', params)
}

/**
 * 创建音频
 * @param {*} params 
 */
export function createVoice(params = {}) {
    return $request.post('/v1/voice/create', params)
}

/**
 * 更新音频
 * @param {*} params 
 */
export function updateVoice(params = {}) {
    return $request.post('/v1/voice/update', params)
}

/**
 * 删除音频
 * @param {*} params 
 */
export function deleteVoice(params = {}) {
    return $request.post('/v1/voice/delete', params)
}