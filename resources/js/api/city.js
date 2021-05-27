import Resource from '@/api/resource';

class ServiceResource extends Resource {
  constructor() {
    super('cities');
  }
}

export { ServiceResource as default };
