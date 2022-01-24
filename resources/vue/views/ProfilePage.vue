<template>
  <Profile :user="user"/>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import {user} from "../stores/user";
import Profile from "../components/Profile.vue";

export default defineComponent({
  components: {
    Profile
  },
  data() {
    return {user};
  },
});
</script>
