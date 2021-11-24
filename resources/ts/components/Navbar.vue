<template>
    <nav>
        <ul>
            <li>Logo</li>
            <li><img :src="profilePicture" />{{ userName }}</li>
            <li><img :src="iconShoppingCart" /></li>
        </ul>
    </nav>
</template>

<script lang="ts">
export default {
    data() {
        return {
            profilePicture: "test",
            userName: "Max Musterman",
            iconShoppingCart: "test",
        };
    },
};
</script>
