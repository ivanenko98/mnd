import Resource from '@/api/resource';
import request from "@/utils/request";

class OrderResource extends Resource {
    constructor() {
        super('orders');
    }
    cancel(id, data) {
        return request({
            url: '/' + this.uri + '/' + id + '/cancel',
            method: 'post',
            data: data,
        });
    }
}

export { OrderResource as default };
