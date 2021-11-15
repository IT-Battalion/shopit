<template>
  <!-- the submit event will no longer reload the page -->
  <form v-on:submit.prevent="submitForm">
    <h1>Login</h1>
    <div class="form-control">
      <label for="user-name">Benutzername</label>
      <input
        id="user-name"
        name="user-name"
        type="text"
        v-model="userName"
        ref="userName"
        v-on:keyup.enter="submitForm"
      />
      <label for="user-password">Passwort</label>
      <input
        id="user-password"
        name="user-name"
        type="password"
        v-model="userPassword"
        ref="userPassword"
        v-on:keyup.enter="submitForm"
      />
      <!-- only call `submitForm()` when the `key` is `Enter` -->
    </div>

    <div>
      <button>Anmelden</button>
    </div>
  </form>
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
      console.log(this.$refs.userName.value + " | " + this.$refs.userPassword.value); // one get input value
    },
  },
};
</script>