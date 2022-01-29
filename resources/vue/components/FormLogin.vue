<template>
  <div class="overflow-hidden bg-backgroundColor" v-if="!isLoading">
    <!-- the submit event will no longer reload the page -->
    <div
      class="
        grid
        w-10/12
        sm:h-[80vh]
        py-10
        px-10
        sm:grid-cols-2 sm:grid-rows-1
        grid-rows-[auto_1fr]
        place-items-center
        bg-elevatedColor
        login-form__container
      "
    >
      <div
        class="
          flex flex-col
          items-center
          justify-center
          w-full
          h-full
          inset-0
          login-form__elevation
          mb-10
          sm:mb-0
        "
      >
        <div class="flex flex-row">
          <img
            src="/img/logo.svg"
            alt="ShopIT Logo"
            class="w-1/4 mb-10 sm:mr-5"
          />
          <img src="/img/IT_Logo.png" alt="IT Logo" class="w-3/4 mb-10" />
        </div>
        <h1
          class="
            text-xl
            sm:text-2xl
            text-white
            lg:text-4xl
            whitespace-nowrap
            mb-2
          "
        >
          Willkommen bei ShopIT!
        </h1>
        <p class="text-md text-center text-gray-400 sm:text-md lg:text-2xl">
          Der Online Shop der Abteilung für Informationstechnologie
        </p>
      </div>
      <form
        @submit.prevent="onSubmit"
        class="
          grid
          mx-3
          sm:mx-0 sm:w-1/2
          grid-rows-6
          gap-2
          md:gap-4
          place-items-center
        "
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
            class="
              w-full
              px-3
              py-2
              leading-tight
              text-white
              bg-gray-900
              rounded
              shadow
              appearance-none
              focus:outline-none focus:shadow-outline
            "
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
            class="
              w-full
              px-3
              py-2
              leading-tight
              text-white
              bg-gray-900
              rounded
              shadow
              appearance-none
              focus:outline-none focus:shadow-outline
            "
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
          <label for="stayLogedIn" class="my-auto ml-2 text-center text-white">
            Angemeldet bleiben
          </label>
        </div>
        <!-- only call `submitForm()` when the `key` is `Enter` -->
        <div class="text-red-400" v-if="user.error.value">
          {{ user.error.value }}
        </div>
        <button
          class="
            px-4
            py-4
            w-full
            md:w-auto md:py-2
            font-bold
            text-white
            bg-gray-800
            rounded
            hover:bg-gray-700
          "
          type="submit"
        >
          Anmelden
        </button>
      </form>
      <div class="col-span-2">
        <a class="
              underline
              opacity-60
              hover:opacity-100
              decoration-solid
              text-white
            "
           href="https://lernenimaufbruch.at/impressum.html"
           target="_blank"
        >Impressum
        </a>
      </div>
    </div>
  </div>
  <div v-else class="text-center grid place-items-center h-[100vh] w-full">
    <div title="0">
      <svg
        version="1.1"
        id="loader-1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        x="0px"
        y="0px"
        width="120px"
        height="120px"
        viewBox="0 0 40 40"
        enable-background="new 0 0 40 40"
        xml:space="preserve"
      >
        <path
          opacity="0.2"
          fill="#fff"
          d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"
        />
        <path
          fill="#fff"
          d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
    C22.32,8.481,24.301,9.057,26.013,10.047z"
        >
          <animateTransform
            attributeType="xml"
            attributeName="transform"
            type="rotate"
            from="0 20 20"
            to="360 20 20"
            dur="0.5s"
            repeatCount="indefinite"
          />
        </path>
      </svg>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, reactive} from "vue";
import {useRoute, useRouter} from "vue-router";
import useUser from "../stores/user";
import userStore from "../stores/user";

export default defineComponent({
  setup() {
    const route = useRoute();
    const {user, login} = useUser();
    const router = useRouter();

    const form = reactive({
      username: "",
      password: "",
      stayLogedIn: false,
    });

    const onSubmit = () => {
      user.error.value = "";
      let username = form.username;
      let password = form.password;

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
      isLoading: false,
    };
  },
  methods: {
    clearForm() {
      this.user.error.value = "";
      this.form.username = "";
      this.form.password = "";
    },
  },
});
</script>

<style>
.login-form__container {
  margin: 10vh 8.33333333%;
  border-radius: 1.5rem;
  box-shadow: 0 0 3rem 0.8rem rgba(0, 0, 0, 0.2);
}
</style>
