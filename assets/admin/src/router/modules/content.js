import Layout from '../../views/layout/Layout'

const ContentRouter = {
    path: '/content',
    component: Layout,
    redirect: '/content/page',
    name: 'Content',
    meta: {
        title: 'content',
        icon: 'documentation'
    },
    children: [
        {
            path: 'page',
            component: () => import('@/views/page/index'),
            name: 'Page',
            meta: { title: 'page' }
        },
        {
            path: 'page/create',
            component: () => import('@/views/page/new'),
            name: 'NewPage',
            meta: { title: 'newPage', noCache: true, parentPath: '/content/page' },
            hidden: true
        },
        {
            path: 'page/edit/:id',
            component: () => import('@/views/page/edit'),
            name: 'EditPage',
            meta: {title: 'editPage', noCache: true, parentPath: '/content/page'},
            hidden: true
        },
        {
            path: 'menu',
            component: () => import('@/views/menu/index'),
            name: 'Menu',
            meta: { title: 'menu' }
        }
    ]
}

export default ContentRouter