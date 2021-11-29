<template>
  <FormLogin />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import FormLogin from "../components/FormLogin.vue";

export default defineComponent({
  name: "Login",
  components: { FormLogin },
});
</script>
