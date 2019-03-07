import { param2Obj } from '@/helper'

const userMap = {
    admin: {
        roles: ['ROLE_ADMIN'],
        token: 'admin',
        introduction: '我是超级管理员',
        avatar: 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
        name: 'Super Admin'
    }
}

export default {
    login: config => {
        //const { username } = JSON.parse(config.body)
        return userMap['admin']
    },
    getUserInfo: config => {
        const { token } = param2Obj(config.url)
        if (userMap[token]) {
            return { data: userMap[token] }
        } else {
            return false
        }
    },
    logout: () => 'success'
}