<template>
    <div class="w-screen h-screen bg-backgroundColor">
        <div class="flex flex-row m-auto">
            <Sidenav></Sidenav>
            <div class="m-auto bg-gray-100"><p>Hilfe</p></div>
        </div>
    </div>
</template>

<script lang="ts">
import Sidenav from "../components/Sidenav.vue";
import Navbar from "../components/Navbar.vue";
export default {
    components: {
        Sidenav,
        Navbar,
    },
};
</script>
