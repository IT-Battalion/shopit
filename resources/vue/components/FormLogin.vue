<template>
  <div class="overflow-hidden bg-backgroundColor">
    <!-- the submit event will no longer reload the page -->
    <div
      class="
        flex flex-row flex-wrap
        w-10/12
        sm:h-[80vh]
        py-10
        px-10
        place-items-center
        bg-elevatedDark
        login-form__container
      "
    >
      <div
        class="inset-0 flex flex-col items-center justify-center w-full h-full mb-10  md:w-1/2 login-form__elevation sm:mb-0"
      >
        <div class="flex flex-row" v-if="!state.isLoading">
          <img
            src="/img/logo.svg"
            alt="ShopIT Logo"
            class="w-1/4 mb-10 sm:mr-5"
          />
          <img src="/img/IT_logo.png" alt="IT Logo" class="w-3/4 mb-10" />
        </div>
        <div v-else>
          <Skeletor :pill="true" class="w-full h-16" />
        </div>
        <h1
          class="mb-2 text-xl text-white  sm:text-2xl lg:text-4xl whitespace-nowrap"
        >
          Willkommen bei ShopIT!
        </h1>
        <p class="text-center text-gray-400 text-md sm:text-md lg:text-2xl">
          Der Online Shop der Abteilung für Informationstechnologie
        </p>
      </div>
      <form
        @submit.prevent="onSubmit"
        class="flex flex-col items-center justify-center w-full md:w-1/2"
      >
        <InputField
          labelName="Benutzername"
          v-model:value="form.username"
          :errorMessage="errorUsername"
          class="w-10/12"
        />
        <InputField
          labelName="Passwort"
          v-model:value="form.password"
          :errorMessage="errorPassword"
          type="password"
          class="w-10/12"
        />
        <div class="flex flex-row items-center justify-center mt-5 mb-10">
          <input
            type="checkbox"
            name="stayLogedIn"
            id="stayLogedIn"
            v-model="stayLogedIn"
          />
          <label for="stayLogedIn" class="my-auto ml-2 text-center text-white">
            Angemeldet bleiben
          </label>
        </div>
        <!-- only call `submitForm()` when the `key` is `Enter` -->
        <span class="mb-10 text-red-400" v-if="user.error.value">
          {{ user.error.value }}
        </span>
        <ButtonField buttonType="submit" :iconSpinner="state.isLoading">
          <template v-slot:text>
            <span>Anmelden</span>
          </template>
          <template v-slot:icon><img src="/img/lockBlack.svg" /></template>
        </ButtonField>
      </form>
      <div class="w-full my-5 text-center md:my-0">
        <a
          class="text-white underline  opacity-60 hover:opacity-100 decoration-solid"
          href="https://lernenimaufbruch.at/impressum.html"
          >Impressum
        </a>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent} from "vue";
import { useRoute, useRouter } from "vue-router";
import { state } from "../loader";
import useUser from "../stores/user";
import userStore from "../stores/user";
import InputField from "./InputField.vue";
import ButtonField from "./ButtonField.vue";

export default defineComponent({
  components: { InputField, ButtonField },
  data() {
    return {
      stayLogedIn: false,
      form: {
        username: "",
        password: "",
        stayLogedIn: false,
      },
      errorUsername: "",
      errorPassword: "",
    };
  },
  setup() {
    const route = useRoute();
    const { user, login } = useUser();
    const router = useRouter();
    return {
      user,
      login,
      userStore,
      route,
      router,
      state,
    };
  },
  methods: {
    clearForm() {
      this.user.error.value = "";
      this.form.username = "";
      this.form.password = "";
    },
    onSubmit() {
      this.errorUsername = "";
      this.errorPassword = "";
      if (this.form.username && this.form.password) {
        console.log(this.form);
        this.user.error.value = "";

        this.login(
          this.form.username,
          this.form.password,
          this.form.stayLogedIn
        ).then((_) => {
          const next = (this.route.params.nextUrl as string) || "/";

          this.router.replace({
            path: next,
          });
        });
      } else {
        if (!this.form.username)
          this.errorUsername = "Der Benutzername ist erforderlich!";
        if (!this.form.password)
          this.errorPassword = "Das Passwort ist erforderlich!";
      }
    },
  },
});
</script>

<style scoped>
.login-form__container {
  margin: 10vh 8.33333333%;
  border-radius: 1.5rem;
  box-shadow: 0 0 3rem 0.8rem rgba(0, 0, 0, 0.2);
}
</style>
