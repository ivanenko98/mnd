import Resource from '@/api/resource';

class OrderResource extends Resource {
    constructor() {
        super('orders');
    }
}

export { OrderResource as default };
