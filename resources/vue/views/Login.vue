<template>
  <FormLogin />
</template>

<script lang="ts">
import { defineComponent, onMounted } from "vue";
import FormLogin from "../components/FormLogin.vue";
import userStore from "../stores/user";

export default defineComponent({
  name: "Login",
  components: { FormLogin },
  setup() {
    return { userStore };
  },
});
</script>
