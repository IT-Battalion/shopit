<template>
  <div class="overflow-hidden bg-backgroundColor">
    <!-- the submit event will no longer reload the page -->
    <div class="grid w-10/12 grid-cols-2 place-items-center bg-elevatedColor login-form__container">
      <div
        class="flex flex-col items-center justify-center w-full h-full inset-0 login-form__elevation"
      >
        <h1 class="text-lg text-white md:text-5xl whitespace-nowrap mb-2">
          Willkommen zurück!
        </h1>
        <p class="text-sm text-gray-400 md:text-2xl">
          Der Fanshop der HIT-Abteilung
        </p>
      </div>
      <form
        @submit.prevent="onSubmit"
        class="grid w-1/2 grid-rows-6 gap-2 md:gap-4 place-items-center"
      >
        <label
          for="username"
          class="block mt-2 text-sm font-bold text-left text-inputLabel"
          >Benutzername</label
        >
        <div>
          <input
            id="username"
            name="username"
            type="text"
            v-model="form.username"
            class="w-full px-3 py-2 leading-tight text-white bg-gray-900 rounded shadow appearance-none  focus:outline-none focus:shadow-outline"
            autofocus
            required
          />
        </div>
        <label
          for="user-password"
          class="block mt-2 text-sm font-bold text-inputLabel"
          >Passwort</label
        >
        <div>
          <input
            id="user-password"
            name="username"
            type="password"
            v-model="form.password"
            class="w-full px-3 py-2 leading-tight text-white bg-gray-900 rounded shadow appearance-none  focus:outline-none focus:shadow-outline"
            required
          />
        </div>
        <div class="flex flex-row">
          <input
            type="checkbox"
            name="stayLogedIn"
            id="stayLogedIn"
            v-model="form.stayLogedIn"
          />
          <label
            for="stayLogedIn"
            class="my-auto ml-2 text-center text-white"
          >
            Angemeldet bleiben
          </label>
        </div>
        <!-- only call `submitForm()` when the `key` is `Enter` -->
        <div class="text-red-400" v-if="user.error.value">
          {{ user.error.value }}
        </div>
        <button
          class="px-4 py-2 font-bold text-white bg-gray-800 rounded  hover:bg-gray-700"
          type="submit"
        >
          Anmelden
        </button>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, reactive} from "vue";
import {useRoute} from "vue-router";
import router from "../router";
import useUser from "../stores/user";
import userStore from "../stores/user";

export default defineComponent({
  setup() {
    const route = useRoute();
    const { user, login } = useUser();

    const form = reactive({
      username: "",
      password: "",
      stayLogedIn: false,
    });

    const onSubmit = () => {
      let username = form.username;
      let password = form.password;

      user.error.value = "";
      form.username = "";
      form.password = "";
      login(username, password, form.stayLogedIn).then((_) => {
        const next = (route.params.nextUrl as string) || "/";

        router.replace({
          path: next,
        });
      });
    };

    return {
      form,
      user,
      userStore,
      onSubmit,
    };
  },
});
</script>

<style>
.login-form__container {
  margin: 10vh 8.33333333%;
  border-radius: 1.5rem;
  height: 80vh;
  box-shadow: 0 0 3rem .8rem rgba(0,0,0,.2);
}

.login-form__elevation {
}
</style>
