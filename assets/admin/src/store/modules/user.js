import { getUserInfo } from '@/api/user'
import { login, logout } from '@/api/auth'
import { getToken, setToken, removeToken } from '@/helper/auth'

export const types = {
    LOGIN: 'login',
    LOGOUT: 'logout',
    FETCH_USER_INFO: 'fetch_user_info',
    SET_ROLES: 'set_roles',
    SET_TOKEN: 'set_token',
    SET_NAME: 'set_name',
    SET_AVATAR: 'set_avatar',
    SET_INTRODUCTION: 'set_introduction',
    SET_SETTING: 'set_setting'
}
const user = {
    state: {
        user: '',
        status: '',
        code: '',
        token: getToken(),
        name: '',
        avatar: '',
        introduction: '',
        roles: [],
        setting: {
            domain: ''
        }
    },

    mutations: {
        [types.SET_ROLES](state, roles) {
            state.roles = roles
        },
        [types.SET_TOKEN](state, token) {
            state.token = token
        },
        [types.SET_NAME](state, name) {
            state.name = name
        },
        [types.SET_AVATAR](state, avatar) {
            state.avatar = avatar
        },
        [types.SET_INTRODUCTION](state, introduction) {
            state.introduction = introduction
        },
        [types.SET_SETTING](state, setting){
            state.setting = setting
        }
    },

    actions: {
        Login({ commit }, userInfo) {
            const username = userInfo.username.trim()
            const password = userInfo.password
            return new Promise((resolve, reject) => {
                login({ username, password }).then(response => {
                    const data = response;
                    commit(types.SET_TOKEN, data.token)
                    setToken(data.token)
                    resolve()
                }).catch(error => {
                    reject(error)
                })
            })
        },
        GetUserInfo({ commit, state }) {
            return new Promise((resolve, reject) => {
                const token = state.token
                getUserInfo().then(response => {
                    if (!response.data) {
                        reject('请求错误')
                    }

                    const data = response.data
                    if (data.roles && data.roles.length > 0) {
                        commit(types.SET_ROLES, data.roles)
                    } else {
                        reject('getInfo: roles must be a non-null array')
                    }

                    commit(types.SET_NAME, data.name)
                    commit(types.SET_AVATAR, data.avatar)
                    commit(types.SET_INTRODUCTION, data.introduction)
                    commit(types.SET_SETTING, data.setting)
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            })
        },
        //登出
        LogOut({ commit, state }) {
            return new Promise((resolve, reject) => {
                logout(state.token).then(() => {
                    commit(types.SET_TOKEN, '')
                    commit(types.SET_ROLES, [])
                    removeToken()
                    resolve()
                }).catch(error => {
                    reject(error)
                })
            })
        },
        //前端登出
        FedLogOut({ commit }) {
            return new Promise(resolve => {
                commit(types.SET_TOKEN, '')
                removeToken()
                resolve()
            })
        }
    }
}

export default user