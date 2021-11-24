<template>
    <div>
        <ul
            class="fixed left-0 flex flex-col justify-center w-40 h-screen m-0 text-white shadow-lg  bg-backgroundColor top-10"
        >
            <a
                v-for="category in categories"
                v-bind:key="category.icon_url"
                v-bind:name="category.name"
                class="flex flex-row my-6 ml-6"
                ><img :src="category.icon_url" class="mr-4" />
                {{ category.name }}</a
            >
        </ul>
    </div>
</template>

<script lang="ts">
export default {
    data() {
        return {
            categories: window.config.categories,
        };
    },
};
</script>

<style></style>
