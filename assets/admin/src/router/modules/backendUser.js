import Layout from '../../views/layout/Layout'

const backendUserRouter = {
    path: '/backend-user',
    component: Layout,
    redirect: '/backend-user/user',
    name: 'BackendUser',
    meta: {
        title: 'Backend-User',
        icon: 'peoples'
    },
    children: [
        {
            path: 'user',
            component: () => import('@/views/backend-user/user/index'),
            name: 'User',
            meta: { title: 'user' }
        },
        {
            path: 'role',
            component: () => import('@/views/backend-user/role/index'),
            name: 'Role',
            meta: { title: 'role' }
        },
        {
            path: 'group',
            component: () => import('@/views/backend-user/group/index'),
            name: 'Group',
            meta: { title: 'group' }
        }
    ]
}

export default backendUserRouter