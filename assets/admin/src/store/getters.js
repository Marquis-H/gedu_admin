const getters = {
    sidebar: state => state.app.sidebar,
    avatar: state => state.user.avatar,
    permission_routers: state => state.permission.routers,
    roles: state => state.user.roles,
    errorLogs: state => state.errorLog.logs,
    addRouters: state => state.permission.addRouters,
    setting: state => state.user.setting
}
export default getters