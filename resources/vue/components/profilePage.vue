<template>
  <div>
    <img
      :src="profilePicture"
      class="object-scale-down h-12 mr-4 bg-gray-800 rounded-full"
    />
    <div>
      <h1>{{ user.name.value }}</h1>
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
    console.log(user);

    return { user, logout, profilePicture };
  },
});
</script>