import Resource from '@/api/resource';

class ServiceResource extends Resource {
  constructor() {
    super('services');
  }
}

export { ServiceResource as default };
