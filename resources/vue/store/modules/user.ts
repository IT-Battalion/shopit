import * as Request from "../../request"
import {getCSRFCookie} from "../../request"
import {redirectToLogin} from "../../util";
import {endLoad, initLoad} from "../../loader";
import {Module} from "vuex";
import {State} from "../index";
import {User} from "../../types/api";

export interface UserState {
  user?: User,
  isLoggedIn?: boolean,
}

const userState: Module<UserState, State> = {
  state() {
    return window.initialConfig.userState;
  },
  getters: {
    name(state) {
      if (!state.user) return "";
      return state.user.firstname + " " + state.user.lastname;
    }
  },
  mutations: {
    user(state, user?: User) {
      state.user = user;
    },
    loggedIn(state, loggedIn: boolean) {
      state.isLoggedIn = loggedIn;
    },
  },
  actions: {
    async login({commit}, loginData: { username: string, password: string, stayLoggedIn: boolean }) {
      initLoad();
      return Request.login(loginData.username, loginData.password, loginData.stayLoggedIn).then(responseUser => {
        commit("loggedIn", true);
        commit("user", responseUser);
        getCSRFCookie();
        return true;
      }).finally(endLoad);
    },
    async logout({commit}) {
      initLoad();
      await Request.logout();
      commit("loggedIn", false);
      endLoad();
      await redirectToLogin();
    }
  },
};

export default userState;
