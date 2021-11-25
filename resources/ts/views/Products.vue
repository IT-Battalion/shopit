<template>
    <div class="w-screen h-screen bg-backgroundColor">
        <div class="flex flex-row m-auto">
            <Sidenav></Sidenav>
            <div class="m-auto bg-gray-100">
                <button @click="userStore.logout()">Abmelden</button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Sidenav from "../components/Sidenav.vue";
import Navbar from "../components/Navbar.vue";
import userStore from "../stores/user";
import user from "../stores/user";
export default {
    components: {
        Sidenav,
        Navbar,
    },
    setup() {
        return { userStore };
    },
};
</script>
