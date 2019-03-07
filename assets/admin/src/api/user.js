import { $request } from 'helper';

/**
 * 获取当前用户
 * @param {*} params 
 */
export function getUserInfo(params = {}) {
    return $request.get('/v1/user/info', params);
}

/**
 * 获取用户列表
 * @param {*} params 
 */
export function getUserList(params = {}) {
    return $request.get('/v1/user/list', params);
}

/**
 * 新增用户
 * @param {*} params 
 */
export function createUser(params = {}) {
    return $request.post('/v1/user/create', params);
}

/**
 * 编辑用户
 * @param {*} params 
 */
export function updateUser(params = {}) {
    return $request.post('/v1/user/update', params)
}

/**
 * 删除用户
 * @param {*} params 
 */
export function deleteUser(params = {}) {
    return $request.post('/v1/user/delete', params)
}

/**
 * 获取权限列表
 * @param {*} params 
 */
export function getRoleList(params = {}) {
    return $request.get('/v1/role/list', params)
}

/**
 * 新增权限
 * @param {*} params 
 */
export function createRole(params = {}) {
    return $request.post('/v1/role/create', params)
}

/**
 * 更新权限
 * @param {*} params 
 */
export function updateRole(params = {}) {
    return $request.post('/v1/role/update', params)
}

/**
 * 删除权限
 * @param {*} params 
 */
export function deleteRole(params = {}) {
    return $request.post('/v1/role/delete', params)
}

/**
 * 获取权限所有选项
 * @param {*} params 
 */
export function itemsRole(params = {}) {
    return $request.get('/v1/role/items', params)
}

/**
 * 获取用户组列表
 * @param {*} params 
 */
export function getGroupList(params = {}) {
    return $request.get('/v1/group/list', params)
}

/**
 * 创建用户组
 * @param {*} params 
 */
export function createGroup(params = {}) {
    return $request.post('/v1/group/create', params)
}

/**
 * 更新用户组
 * @param {*} params 
 */
export function updateGroup(params = {}) {
    return $request.post('/v1/group/update', params)
}

/**
 * 删除用户组
 * @param {*} params 
 */
export function deleteGroup(params = {}) {
    return $request.post('/v1/group/delete', params)
}

/**
 * 获取用户组所有选项
 * @param {*} params 
 */
export function itemsGroup(params = {}) {
    return $request.get('/v1/group/items', params)
}