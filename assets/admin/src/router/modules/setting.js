import Layout from '../../views/layout/Layout'

const settingRouter = {
    path: '/setting',
    component: Layout,
    redirect: '/setting/system',
    name: 'setting',
    meta: {
        title: 'setting',
        icon: 'setting'
    },
    children: [
        {
            path: 'system',
            component: () => import('@/views/setting/system/index'),
            name: 'System',
            meta: { title: 'system' }
        },
        {
            path: 'frontend',
            component: () => import('@/views/setting/frontend/index'),
            name: 'Frontend',
            meta: { title: 'frontend' }
        }
    ]
}

export default settingRouter