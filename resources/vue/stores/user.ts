import { computed, reactive, toRefs } from 'vue'
import * as Request from '../request'
import router from '../router'

export const user = reactive({
  username: '',
  name: '',
  firstname: '',
  lastname: '',
  email: '',
  employeeType: '',
  class: '',
  lang: '',
  isAdmin: false,
  isLoggedIn: window.config.user.logged_in,

  error: ''
})

const actions = {
  async login(username: string, password: string) {
    return Request.login(username, password).then(responseUser => {
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
      console.error(err);
    });
  },
  async logout() {
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

    router.push({
      name: 'Login',
      params: { nextUrl: router.currentRoute.value.fullPath },
    });
  }
}

export default { user, ...actions }