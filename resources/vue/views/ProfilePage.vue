<template>
  <Profile :user="user"/>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";
import Profile from "../components/Profile.vue";

export default defineComponent({
  components: {
    Profile
  },
  computed: {
    user() {
      return this.$store.state.userState.user!;
    }
  },
});
</script>
