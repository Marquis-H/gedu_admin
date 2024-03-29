import { asyncRouterMap, constantRouterMap } from '@/router'

export const types = {
    SET_ROUTERS: 'set_routers'
}

function hasPermission(roles, route) {
    if (route.meta && route.meta.roles) {
        return roles.some(role => route.meta.roles.indexOf(role) >= 0)
    } else {
        return true
    }
}

function filterAsyncRouter(asyncRouterMap, roles) {
    const accessedRouters = asyncRouterMap.filter(route => {
        if (hasPermission(roles, route)) {
            if (route.children && route.children.length) {
                route.children = filterAsyncRouter(route.children, roles)
            }
            return true
        }
        return false
    })
    return accessedRouters
}

const permission = {
    state: {
        routers: constantRouterMap,
        addRouters: []
    },

    mutations: {
        [types.SET_ROUTERS](state, routers) {
            state.addRouters = routers
            state.routers = constantRouterMap.concat(routers)
        }
    },

    actions: {
        GenerateRoutes({ commit }, data) {
            return new Promise(resolve => {
                const { roles } = data
                let accessedRouters
                if (roles.indexOf('ROLE_ADMIN') > 0) {
                    accessedRouters = asyncRouterMap
                } else {
                    accessedRouters = filterAsyncRouter(asyncRouterMap, roles)
                }

                commit(types.SET_ROUTERS, accessedRouters)
                resolve()
            })
        }
    }
}

export default permission