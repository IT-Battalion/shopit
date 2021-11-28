<template>
  <div class="w-screen h-screen bg-backgroundColor">
    <!-- the submit event will no longer reload the page -->
    <div
      class="absolute flex items-center justify-center w-full h-full overflow-hidden  top-4"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        width="1544"
        height="1020.002"
        viewBox="0 0 1544 1020.002"
      >
        <defs>
          <filter
            id="a"
            x="51"
            y="21"
            width="1493"
            height="930"
            filterUnits="userSpaceOnUse"
          >
            <feOffset dx="6" dy="6" input="SourceAlpha" />
            <feGaussianBlur stdDeviation="15" result="b" />
            <feFlood flood-opacity="0.161" />
            <feComposite operator="in" in2="b" />
            <feComposite in="SourceGraphic" />
          </filter>
          <filter
            id="c"
            x="0"
            y="0"
            width="881"
            height="1020.002"
            filterUnits="userSpaceOnUse"
          >
            <feOffset dy="30" input="SourceAlpha" />
            <feGaussianBlur stdDeviation="30" result="d" />
            <feFlood flood-opacity="0.161" />
            <feComposite operator="in" in2="d" />
            <feComposite in="SourceGraphic" />
          </filter>
          <filter
            id="e"
            x="44.999"
            y="29.999"
            width="791"
            height="930.003"
            filterUnits="userSpaceOnUse"
          >
            <feOffset dy="15" input="SourceAlpha" />
            <feGaussianBlur stdDeviation="15" result="f" />
            <feFlood flood-opacity="0.161" />
            <feComposite operator="in" in2="f" />
            <feComposite in="SourceGraphic" />
          </filter>
        </defs>
        <g transform="translate(-169 -60)">
          <g class="d" transform="matrix(1, 0, 0, 1, 169, 60)">
            <rect
              class="a"
              width="1403"
              height="840"
              rx="24"
              transform="translate(90 60)"
            />
          </g>
          <g class="c" transform="matrix(1, 0, 0, 1, 169, 60)">
            <path
              class="a"
              d="M701,878H24A24,24,0,0,1,0,854V62A24,24,0,0,1,24,38H701V878Z"
              transform="translate(90 22)"
            />
          </g>
          <g class="b" transform="matrix(1, 0, 0, 1, 169, 60)">
            <path
              class="a"
              d="M701,1014l-375.332,0A267.861,267.861,0,0,0,0,821.33V198a24,24,0,0,1,24-24H528c.264,95.121,77.87,172.728,173,173v667Z"
              transform="translate(90 -114)"
            />
          </g>
        </g>
      </svg>
    </div>
    <div class="flex items-center justify-center">
      <div class="relative grid w-3/4 h-screen grid-cols-2 place-items-center">
        <div class="w-1/2">
          <h1 class="text-white">Login</h1>
        </div>
        <form
          @submit.prevent="onSubmit"
          class="grid w-1/2 grid-rows-6 gap-2 md:gap-4 place-items-center"
        >
          <label
            for="username"
            class="block mb-2 text-sm font-bold text-left text-inputLabel"
            >Benutzername</label
          >
          <div>
            <input
              id="username"
              name="username"
              type="text"
              v-model="form.username"
              class="w-full px-3 py-2 leading-tight text-white bg-gray-900 rounded shadow appearance-none  focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          <label
            for="user-password"
            class="block mb-2 text-sm font-bold text-inputLabel"
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
            <p class="my-auto ml-2 text-center text-white">
              Angemeldet bleiben
            </p>
          </div>
          <!-- only call `submitForm()` when the `key` is `Enter` -->
          <div class="text-red-400">
            {{ userStore.user.error }}
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
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from "vue";
import { useRoute } from "vue-router";
import router from "../router";
import userStore from "../stores/user";

export default defineComponent({
  setup() {
    const route = useRoute();

    const form = reactive({
      username: "",
      password: "",
      stayLogedIn: false,
    });

    const onSubmit = () => {
      userStore.login(form.username, form.password).then((_) => {
        form.username = "";
        form.password = "";

        const next = (route.params.nextUrl as string) || "/";

        router.replace({
          path: next,
        });
      });
    };

    return {
      form,
      userStore,
      onSubmit,
    };
  },
});
</script>

<style>
.a {
  fill: #323c50;
}

.b {
  filter: url(#e);
}

.c {
  filter: url(#c);
}

.d {
  filter: url(#a);
}
</style>
