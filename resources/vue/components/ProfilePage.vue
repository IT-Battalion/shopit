<template>
  <div class="w-full h-full">
    <img
      :src="profilePicture"
      class="bg-gray-800 rounded-full md:w-1/5 w-2/5 mx-auto"
    />
    <div>
      <h1 class="text-white text-5xl text-center font-bold mt-10">
        {{ user.name.value }}
      </h1>
      <hr class="my-10 mx-auto border-linecolor w-1/6 border-2 rounded-full" />
      <div class="text-white text-center text-2xl font-medium">
        <h2 v-if="user.isAdmin">Admin</h2>
        <h2 class="mt-3">
          {{ user.username.value }}<a class="text-gray-600">{{ email }}</a>
        </h2>
        <mq-responsive target="sm-">
          <button
            class="
              flex
              items-center
              justify-center
              w-1/2
              text-base
              font-medium
              text-gray-900
              bg-white
              row-span-full
              rounded-3xl
              hover:bg-gray-300
              mx-auto
              py-2
              mt-5
            "
            type="button"
            @click="logout()"
          >
            <a class="pr-2">Abmelden</a>
            <img src="img/logoutBlack.svg" class="object-scale-down h-10" />
          </button>
        </mq-responsive>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import useUser from "../stores/user";

export default defineComponent({
  setup() {
    const { user, logout } = useUser();
    const profilePicture =
      "https://avatars.dicebear.com/api/micah/:" + user.username.value + ".svg";
    const email = user.email.value.slice(
      user.email.value.lastIndexOf("@"),
      user.email.value.length
    );

    return { user, profilePicture, email, logout };
  },
});
</script>