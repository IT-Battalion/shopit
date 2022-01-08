<template>
  <div class="justify-center w-full flex flex-row items-center gap-5">
    <template v-for="process in orderProcess" :key="process.name">
      <div class="flex flex-col items-center">
        <img :src="process.icon_url" :alt="process.name" />
        <a class="text-base mt-3 text-white text-center">{{ process.name }}</a>
      </div>
      <span
        class="w-20 h-2 bg-white rounded-full"
        v-if="process.name !== 'Abgeschlossen'"
      />
    </template>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  setup() {
    const orderProcess = [
      {
        name: "Bestellt",
        icon_url: "../img/orderOrdered.svg",
      },
      {
        name: "Bezahlen",
        icon_url: "../img/orderPayed.svg",
      },
      {
        name: "Auf Produkt warten",
        icon_url: "../img/orderWaiting.svg",
      },
      {
        name: "Abholen",
        icon_url: "../img/orderCollect.svg",
      },
      {
        name: "Abgeschlossen",
        icon_url: "../img/orderComplete.svg",
      },
    ];
    return { orderProcess };
  },
});
</script>