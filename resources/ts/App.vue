<template>
    <div id="nav">
        <router-link to="/">Home</router-link> |
        <router-link to="/products">Products</router-link>
    </div>
    <router-view />
    <FormLogin />
</template>

<script lang="ts">
import { defineComponent, onMounted } from "vue";
import FormLogin from "./components/FormLogin.vue";
import userStore from "./stores/user";
import Products from "./views/Products.vue";

export default defineComponent({
    name: "Login",
    components: { FormLogin, Products },
    setup() {
        onMounted(userStore.getUser);
        return { userStore };
    },
});
</script>
