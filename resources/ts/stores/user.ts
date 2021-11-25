import { computed, reactive } from 'vue'
import * as Request from '../request'
import router from '../router'

const state = reactive({
  name: '',
  username: '',
  isLoggedIn: window.config.user.logged_in,

  error: ''
})

const getters = reactive({
  isLoggedIn: computed(() => state.username !== '')
})

const actions = {
  async getUser() {
    const user = await Request.getUser()
    if (user == null) return

    state.name = user.name
    state.username = user.username
  },
  async login(username: string, password: string) {
    Request.login(username, password).then(user => {
      state.isLoggedIn = true;
      state.name = user.name;
      state.username = username;
      state.error = '';

      router.push('/products')

      return true;
    }).catch(err => {
      console.error(err);
    });
  },
  async logout() {
    Request.logout();
    state.isLoggedIn = false;
    state.name = '';
    state.username = '';
  }
}

export default { state, getters, ...actions }