<template>
  <div class="flex flex-col items-center justify-center w-full">
    <div class="w-2/5 md:w-1/5 aspect-[1/1] mx-auto">
      <LoadingImage
        :src="profilePicture"
        class="w-full mx-auto bg-gray-800 rounded-full"
        v-if="!loading"
      />
      <Skeletor v-else circle class="aspect-[1/1]" />
    </div>
    <div class="flex flex-col items-center justify-center">
      <h1
        class="mt-10 text-5xl font-bold text-center text-white"
        v-if="!loading"
      >
        {{ user.firstname }} {{ user.lastname }}
      </h1>
      <Skeletor
        v-else
        :pill="true"
        width="250"
        class="mt-10 text-5xl font-bold text-center text-white"
      />
      <hr
        class="hidden w-1/6 mx-auto my-10 border-2 rounded-full  md:shown border-linecolor"
      />
      <div class="mt-10 text-2xl font-medium text-center text-white md:mt-0">
        <h2 v-if="user.isAdmin">Administrator</h2>
        <h2 v-else>Benutzer</h2>
        <h2 class="mt-3" v-if="!loading">
          {{ user.username }}<wbr /><span class="text-gray-600">{{
            email
          }}</span>
        </h2>
        <Skeletor v-else :pill="true" width="400" class="mt-3" />
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
import { logout } from "../request";
import { User } from "../types/api";
import { PropType } from "vue";
import LoadingImage from "./LoadingImage.vue";

export default defineComponent({
  components: { LoadingImage },
  props: {
    user: {
      type: Object as PropType<User>,
      required: true,
    },
    loading: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    profilePicture() {
      return (
        "https://avatars.dicebear.com/api/micah/" + this.user.username + ".svg"
      );
    },
    email() {
      return this.user.email?.slice(
        this.user.email.lastIndexOf("@"),
        this.user.email.length
      );
    },
  },
  methods: {
    logout() {
      logout();
    },
  },
});
</script>
