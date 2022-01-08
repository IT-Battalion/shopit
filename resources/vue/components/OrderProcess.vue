<template>
  <div
    class="grid justify-center w-full grid-cols-10 grid-rows-2  justify-items-center"
  >
    <template v-for="process in orderProcess" :key="process.name">
      <img
        :src="process.icon_url"
        :alt="process.name"
        class="col-span-1 row-span-1"
      />
      <a class="col-span-1 row-span-1 text-xl text-white">{{ process.name }}</a>
      <hr
        class="w-20 col-span-1 row-span-2 border-white rounded-full border-6"
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