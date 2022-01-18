<template>
  <div class="flex flex-col items-center justify-center w-full">
    <img
      :src="profilePicture"
      class="w-2/5 mx-auto bg-gray-800 rounded-full md:w-1/5"
    />
    <div>
      <h1 class="mt-10 text-5xl font-bold text-center text-white">
        {{ user.name.value }}
      </h1>
      <hr
        class="hidden w-1/6 mx-auto my-10 border-2 rounded-full  md:shown border-linecolor"
      />
      <div class="mt-10 text-2xl font-medium text-center text-white md:mt-0">
        <h2 v-if="user.isAdmin">Admin</h2>
        <h2 class="mt-3">
          {{ user.username.value }}<wbr /><span class="text-gray-600">{{
            email
          }}</span>
        </h2>
        <mq-responsive target="sm-">
          <button
            class="flex items-center justify-center px-10 py-3 mx-auto mt-10 text-base font-medium text-gray-900 bg-white  row-span-full rounded-3xl hover:bg-gray-300 md:mt-5"
            type="button"
            @click="logout()"
          >
            <a class="pr-2">Abmelden</a>
            <img src="/img/logoutBlack.svg" class="object-scale-down h-10" />
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
