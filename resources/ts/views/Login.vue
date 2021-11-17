<template>
    <div class="w-screen h-screen bg-backgroundColor">
        <!-- the submit event will no longer reload the page -->
        <div
            class="absolute w-full transform -translate-x-1/2 -translate-y-1/2  top-1/2 left-1/2"
        >
            <img src="../assets/loginBackground.svg" alt="back" />
        </div>
        <div class="relative grid h-screen ml-10 mr-10 place-items-center">
            <form
                v-on:submit.prevent="submitForm"
                class="grid grid-cols-2 gap-4"
            >
                <div>
                    <h1 class="text-white">Login</h1>
                </div>
                <div class="grid gap-4 form-control">
                    <div>
                        <label for="user-name" class="text-inputLabel"
                            >Benutzername</label
                        >
                    </div>
                    <div>
                        <input
                            id="user-name"
                            name="user-name"
                            type="text"
                            v-model="userName"
                            ref="userName"
                            v-on:keyup.enter="submitForm"
                            class="w-40"
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
                            name="user-name"
                            type="password"
                            v-model="userPassword"
                            ref="userPassword"
                            v-on:keyup.enter="submitForm"
                            class="w-40"
                        />
                    </div>
                    <!-- only call `submitForm()` when the `key` is `Enter` -->
                </div>
                <div></div>
                <div>
                    <button class="text-white" type="submit">Anmelden</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script lang="ts">
export default {
    data() {
        return {
            userName: "",
            userPassword: "",
        };
    },
    methods: {
        submitForm() {
            console.log(
                this.$refs.userName.value +
                    " | " +
                    this.$refs.userPassword.value
            ); // one get input value
        },
    },
};
</script>
