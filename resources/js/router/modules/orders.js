import Layout from "@/layout/index";

/** When your routing table is too long, you can split it into small modules**/

const ordersRoutes = {
    path: '/orders',
    component: Layout,
    redirect: '/orders/index',
    meta: {title: 'orders', icon: 'component', permissions: ['manage orders']},
    children: [
        /** Order's management */
        {
            path: 'edit/:id(\\d+)',
            component: () => import('@/views/orders/Edit'),
            name: 'Edit Order',
            meta: {title: 'edit_order', noCache: true, permissions: ['manage orders']},
            hidden: true,
        },
        {
            path: 'index',
            component: () => import('@/views/orders/List'),
            name: 'Orders',
            meta: {title: 'orders', icon: 'component', permissions: ['manage orders']},
        },
    ],
};

export default ordersRoutes;
