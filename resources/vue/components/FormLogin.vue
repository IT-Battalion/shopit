<template>
    <div class="w-screen h-screen bg-backgroundColor">
        <!-- the submit event will no longer reload the page -->
        <div class="absolute grid h-screen place-items-center">
            <img src="/img/loginBackground.svg" alt="back" />
        </div>
        <div class="relative grid h-screen ml-10 mr-10 place-items-center">
            <form @submit.prevent="onSubmit" class="grid grid-cols-2 gap-4">
                <div>
                    <h1 class="text-white">Login</h1>
                </div>
                <div class="grid gap-4 form-control">
                    <div>
                        <label for="username" class="text-inputLabel"
                            >Benutzername</label
                        >
                    </div>
                    <div>
                        <input
                            id="username"
                            name="username"
                            type="text"
                            v-model="form.username"
                            class="w-40"
                            required
                        />
                    </div>
                    <div>
                        <label for="user-password" class="text-inputLabel"
                            >Passwort</label
                        >
                    </div>
                    <div>
                        <input
                            id="user-password"
                            name="username"
                            type="password"
                            v-model="form.password"
                            class="w-40"
                            required
                        />
                    </div>
                    <div class="flex flex-row">
                        <input
                            type="checkbox"
                            name="stayLogedIn"
                            id="stayLogedIn"
                            v-model="form.stayLogedIn"
                        />
                        <p class="ml-2 text-white">Angemeldet bleiben</p>
                    </div>
                    <!-- only call `submitForm()` when the `key` is `Enter` -->
                </div>
                <div></div>
                <div>
                    <div class="text-red-400">
                        {{ userStore.user.error }}
                    </div>
                    <button class="text-white" type="submit">Anmelden</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from "vue";
import { useRoute } from "vue-router";
import router from "../router";
import userStore from "../stores/user";

export default defineComponent({
    setup() {
        const route = useRoute();

        const form = reactive({
            username: "",
            password: "",
            stayLogedIn: false,
        });

        const onSubmit = () => {
            userStore.login(form.username, form.password).then(_ => {
                form.username = "";
                form.password = "";

                const next = route.params.nextUrl as string || '/';

                router.replace({
                    path: next,
                });
            });
        };

        return { form, userStore, onSubmit };
    },
});
</script>
