import { $request } from 'helper';

/**
 * 获取单词列表
 * @param {*} params 
 */
export function getWordList(params = {}) {
    return $request.get('/v1/word/list', params)
}

/**
 * 更新单词标签
 * @param {*} params 
 */
export function updateWordTabs(params = {}) {
    return $request.post('/v1/word/update_tabs', params)
}
