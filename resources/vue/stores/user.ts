import {reactive, toRefs} from 'vue'
import * as Request from '../request'
import {redirectToLogin} from "../util";
import {endLoad, initLoad} from "../loader";

export const user = reactive({
  username: window.config.user.username ?? '',
  name: window.config.user.name ?? '',
  firstname: window.config.user.firstname ?? '',
  lastname: window.config.user.lastname ?? '',
  email: window.config.user.email ?? '',
  employeeType: window.config.user.employeeType ?? '',
  class: window.config.user.class ?? '',
  lang: window.config.user.lang ?? '',
  isAdmin: window.config.user.isAdmin ?? false,
  isLoggedIn: window.config.user.isLoggedIn ?? false,

  error: ''
})

const actions = {
  async login(username: string, password: string, stayLoggedIn: boolean) {
    initLoad();
    return Request.login(username, password, stayLoggedIn).then(responseUser => {
      user.isLoggedIn = true;
      user.username = responseUser.username;
      user.name = responseUser.name;
      user.firstname = responseUser.firstname;
      user.lastname = responseUser.lastname;
      user.email = responseUser.lastname;
      user.employeeType = responseUser.employeeType;
      user.class = responseUser.class;
      user.lang = responseUser.lang;
      user.isAdmin = responseUser.isAdmin;

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
