import {reactive, toRefs} from "vue"
import * as Request from "../request"
import {redirectToLogin} from "../util";
import {endLoad, initLoad} from "../loader";
import {getCSRFCookie} from "../request";
import {useToast} from "vue-toastification";
import {User} from "../types/api";

export const user = reactive({
  id: window.initialConfig.user.id ?? "",
  username: window.initialConfig.user.username ?? "",
  name: (window.initialConfig.user.firstname + " " + window.initialConfig.user.lastname) ?? "",
  firstname: window.initialConfig.user.firstname ?? "",
  lastname: window.initialConfig.user.lastname ?? "",
  email: window.initialConfig.user.email ?? "",
  lang: window.initialConfig.user.lang ?? "",
  isAdmin: window.initialConfig.user.is_admin ?? false,
  isLoggedIn: window.initialConfig.user.isLoggedIn ?? false,
})

const actions = {
  async login(username: string, password: string, stayLoggedIn: boolean) {
    initLoad();
    return Request.login(username, password, stayLoggedIn).then(responseUser => {
      user.isLoggedIn = true;
      user.id = responseUser.id;
      user.username = responseUser.username;
      user.firstname = responseUser.firstname;
      user.lastname = responseUser.lastname;
      user.name = user.firstname + " " + user.lastname;
      user.email = responseUser.email;
      user.lang = responseUser.lang;
      user.isAdmin = responseUser.is_admin;

      getCSRFCookie();
      return true;
    }).finally(endLoad);
  },
  async logout() {
    initLoad();
    await Request.logout();
    user.isLoggedIn = false;
    user.username = "";
    user.name = "";
    user.firstname = "";
    user.lastname = "";
    user.email = "";
    user.lang = "";
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
