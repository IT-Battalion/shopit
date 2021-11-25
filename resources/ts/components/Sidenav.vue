<template>
    <div>
        <ul
            class="fixed left-0 flex flex-col justify-center w-40 h-screen m-0 text-white shadow-lg  bg-backgroundColor top-10"
        >
            <div
                v-for="category in categories"
                v-bind:key="category.icon_url"
                v-bind:name="category.name"
                class="flex flex-row my-6 ml-6"
            >
                <img
                    :src="category.icon_url"
                    class="object-scale-down h-8 mr-4"
                />
                <p class="my-1 text-left">{{ category.name }}</p>
            </div>
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
