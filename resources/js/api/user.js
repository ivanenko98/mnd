import request from '@/utils/request';
import Resource from '@/api/resource';

class UserResource extends Resource {
  constructor() {
    super('users');
  }

    setLanguage(lang) {
        return request({
            url: '/' + this.uri + '/set-lang',
            method: 'post',
            data: {lang: lang},
        });
    }

    listMasters() {
        return request({
            url: '/' + this.uri + '/masters',
            method: 'get',
        });
    }
  //
  // permissions(id) {
  //   return request({
  //     url: '/' + this.uri + '/' + id + '/permissions',
  //     method: 'get',
  //   });
  // }
  //
  // updatePermission(id, permissions) {
  //   return request({
  //     url: '/' + this.uri + '/' + id + '/permissions',
  //     method: 'put',
  //     data: permissions,
  //   });
  // }
}

export { UserResource as default };
