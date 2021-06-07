import Layout from "@/layout/index";

/** When your routing table is too long, you can split it into small modules**/

const usersRoutes = {
    path: '/users',
    component: Layout,
    redirect: 'users',
    children: [
        /** User managements */
        {
            path: 'edit/:id(\\d+)',
            component: () => import('@/views/users/UserProfile'),
            name: 'UserProfile',
            meta: {title: 'userProfile', noCache: true},
            hidden: true,
        },
        {
            path: '',
            component: () => import('@/views/users/List'),
            name: 'UserList',
            meta: {title: 'users', icon: 'user', permissions: ['manage user']},
        },
    ],
};

export default usersRoutes;
