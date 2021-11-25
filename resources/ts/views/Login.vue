<template>
    <div v-if="!userStore.getters.isLoggedIn">
        <FormLogin />
    </div>
    <div v-else>
        <!-- <h2>Willkommen, {{ userStore.state.name }}</h2> -->
        <Products />
    </div>
</template>

<script lang="ts">
import { defineComponent, onMounted } from "vue";
import FormLogin from "../components/FormLogin.vue";
import userStore from "../stores/user";
import Products from "./Products.vue";

export default defineComponent({
    name: "Login",
    components: { FormLogin, Products },
    setup() {
        onMounted(userStore.getUser);
        return { userStore };
    },
});
</script>
