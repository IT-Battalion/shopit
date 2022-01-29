import {reactive, toRefs} from 'vue'
import * as Request from '../request'
import {redirectToLogin} from "../util";
import {endLoad, initLoad} from "../loader";
import {getCSRFCookie} from "../request";
import {useToast} from "vue-toastification";

export const user = reactive({
  id: window.initialConfig.user.id ?? '',
  username: window.initialConfig.user.username ?? '',
  name: window.initialConfig.user.name ?? '',
  firstname: window.initialConfig.user.firstname ?? '',
  lastname: window.initialConfig.user.lastname ?? '',
  email: window.initialConfig.user.email ?? '',
  lang: window.initialConfig.user.lang ?? '',
  isAdmin: window.initialConfig.user.is_admin ?? false,
  isLoggedIn: window.initialConfig.user.isLoggedIn ?? false,

  error: '',
})

const actions = {
  async login(username: string, password: string, stayLoggedIn: boolean) {
    initLoad();
    let toast = useToast();
    return Request.login(username, password, stayLoggedIn).then(responseUser => {
      user.error = '';
      user.isLoggedIn = true;
      user.id = responseUser.id;
      user.username = responseUser.username;
      user.firstname = responseUser.firstname;
      user.lastname = responseUser.lastname;
      user.name = user.firstname + ' ' + user.lastname;
      user.email = responseUser.email;
      user.lang = responseUser.lang;
      user.isAdmin = responseUser.is_admin;
      toast.success("Erfolgreich eingeloggt.");

      getCSRFCookie();
      return true;
    }).catch(err => {
      if (err.response.status === 401) {
        user.error = err.response.data.message;
        toast.error(user.error);
      } else {
        toast.error("Fehler beim Anmelden.");
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
