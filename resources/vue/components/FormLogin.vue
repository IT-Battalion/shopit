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
        <div class="flex flex-row">
          <LoadingImage
            alt="ShopIT Logo"
            class="w-1/4 mb-10 sm:mr-5"
            src="/img/logo.svg"
          />
          <LoadingImage alt="IT Logo" class="w-3/4 mb-10" src="/img/IT_logo.png"/>
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
        class="flex flex-col items-center justify-center w-full md:w-1/2"
        @submit.prevent="onSubmit"
      >
        <InputField
          v-model:value="form.username"
          :errorMessage="errorUsername"
          class="w-10/12"
          labelName="Benutzername"
        />
        <InputField
          v-model:value="form.password"
          :errorMessage="errorPassword"
          class="w-10/12"
          labelName="Passwort"
          type="password"
        />
        <div class="flex flex-row items-center justify-center mt-5 mb-10">
          <input
            id="stayLogedIn"
            v-model="stayLoggedIn"
            name="stayLogedIn"
            type="checkbox"
          />
          <label class="my-auto ml-2 text-center text-white" for="stayLogedIn">
            Angemeldet bleiben
          </label>
        </div>
        <ButtonField :loading="state.isLoading" type="submit">
          <template v-slot:text>
            <span>Anmelden</span>
          </template>
          <template v-slot:icon><img src="/img/lockBlack.svg"/></template>
        </ButtonField>
      </form>
      <div class="w-full my-5 text-center md:my-0">
        <router-link :to="{name: 'impressum'}"
                     class="text-white underline  opacity-60 hover:opacity-100 decoration-solid">
          Impressum
        </router-link>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {useRoute, useRouter} from "vue-router";
import {endLoad, initLoad, state} from "../loader";
import InputField from "./InputField.vue";
import ButtonField from "./ButtonField.vue";
import LoadingImage from "./LoadingImage.vue";
import {useToast} from "vue-toastification";
import {AxiosError} from "axios";
import {HttpStatusCode} from "../types/api-values";
import {cloneDeep, join} from "lodash";
import {mapActions} from "vuex";
import {redirectRouteAfterLogin} from "../router";

export default defineComponent({
  components: {LoadingImage, InputField, ButtonField},
  data() {
    return {
      stayLoggedIn: false,
      form: {
        username: "",
        password: "",
        stayLoggedIn: false,
      },
      errorUsername: "",
      errorPassword: "",
    };
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const toast = useToast();
    return {
      route,
      router,
      toast,
      state,
    };
  },
  computed: {
    user() {
      return this.$store.state.userState.user;
    }
  },
  methods: {
    clearForm() {
      this.form.username = "";
      this.form.password = "";
    },
    async onSubmit() {
      let {username, password, stayLoggedIn} = cloneDeep(this.form);
      username = username.trim();
      password = password.trim();

      if (username && password) {
        try {
          initLoad();
          await this.login({
            username,
            password,
            stayLoggedIn,
          });

          this.toast.success("Erfolgreich angemeldet.");
          const lastActiveRoute = redirectRouteAfterLogin();

          await this.router.replace(lastActiveRoute);

          this.clearForm();
          endLoad();
        } catch (e) {
          if ("response" in (e as AxiosError)) {
            const error = e as AxiosError;
            console.log(error.response);
            this.toast.error(error.response?.data.message);

            switch (error.response?.status) {
              case HttpStatusCode.Unauthorized:
                this.errorUsername = this.errorPassword = error.response?.data.message;
                break;
              case HttpStatusCode.UnprocessableEntity:
                const errors = error.response?.data.errors as { username: string[], password: string[] };
                this.errorUsername = join(errors.username, ", ");
                this.errorPassword = join(errors.password, ", ");
                break;
            }
          } else {
            throw e;
          }
        }
      } else {
        if (!username)
          this.errorUsername = "Der Benutzername ist erforderlich!";
        if (!password)
          this.errorPassword = "Das Passwort ist erforderlich!";
      }
    },
    ...mapActions([
      "login",
    ]),
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
