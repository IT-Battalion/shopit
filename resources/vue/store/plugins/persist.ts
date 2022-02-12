import VuexPersistence, {AsyncStorage} from "vuex-persist";
import {State} from "../index";
import localforage from "localforage";

export default new VuexPersistence<State>({
  storage: localforage as AsyncStorage,
  asyncStorage: true,
  modules: [],
});
