import {reactive, toRefs} from 'vue'
import * as Request from '../request'
import {redirectToLogin} from "../util";
import {endLoad, initLoad} from "../loader";

export const user = reactive({
  id: window.initialConfig.user.id ?? '',
  username: window.initialConfig.user.username ?? '',
  name: window.initialConfig.user.name ?? '',
  firstname: window.initialConfig.user.firstname ?? '',
  lastname: window.initialConfig.user.lastname ?? '',
  email: window.initialConfig.user.email ?? '',
  employeeType: window.initialConfig.user.employeeType ?? '',
  class: window.initialConfig.user.class ?? '',
  lang: window.initialConfig.user.lang ?? '',
  isAdmin: window.initialConfig.user.is_admin ?? false,
  isLoggedIn: window.initialConfig.user.isLoggedIn ?? false,

  error: ''
})

const actions = {
  async login(username: string, password: string, stayLoggedIn: boolean) {
    initLoad();
    return Request.login(username, password, stayLoggedIn).then(responseUser => {
      user.isLoggedIn = true;
      user.id = responseUser.id;
      user.username = responseUser.username;
      user.name = responseUser.name;
      user.firstname = responseUser.firstname;
      user.lastname = responseUser.lastname;
      user.email = responseUser.email;
      user.employeeType = responseUser.employeeType;
      user.class = responseUser.class;
      user.lang = responseUser.lang;
      user.isAdmin = responseUser.is_admin;

      return true;
    }).catch(err => {
      if (err.response.status === 401) {
        user.error = err.response.data.message;
      }
      return err;
    }).finally(endLoad);
  },
  async logout() {
    initLoad();
    await Request.logout();
    user.isLoggedIn = false;
    user.username = '';
    user.name = '';
    user.firstname = '';
    user.lastname = '';
    user.email = '';
    user.employeeType = '';
    user.class = '';
    user.lang = '';
    user.isAdmin = false;

    endLoad();
    await redirectToLogin();
  }
}

export default function useUser() {
  return {
    user: toRefs(user),
    ...actions,
  }
}
