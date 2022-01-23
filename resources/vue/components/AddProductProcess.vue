<template>
  <mq-responsive target="lg+">
    <div class="flex flex-row items-center justify-center w-full gap-5">
      <template v-for="process in orderProcess" :key="process.name">
        <div class="flex flex-col items-center">
          <img :src="process.icon_url" :alt="process.name" class="h-10 w-10" />
          <span class="mt-3 text-base text-center text-white">{{
            process.name
          }}</span>
        </div>
        <span
          class="w-20 h-2 bg-white rounded-full"
          v-if="process.name !== 'Beschreibung'"
        />
      </template>
    </div>
  </mq-responsive>
  <mq-responsive target="md-">
    <div class="flex flex-col items-center gap-5 ml-auto mr-0">
      <template v-for="process in orderProcess" :key="process.name">
        <img :src="process.icon_url" :alt="process.name" class="h-10 w-10" />
        <span
          class="w-1 h-10 bg-white rounded-full"
          v-if="process.name !== 'Beschreibung'"
        />
      </template>
    </div>
  </mq-responsive>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  setup() {
    const orderProcess = [
      {
        name: "Preis & Titel",
        icon_url: "/img/titelPrice.svg",
      },
      {
        name: "Bilddatein",
        icon_url: "/img/images.svg",
      },
      {
        name: "Kategorien & Attribute",
        icon_url: "/img/editBlockAttributes.svg",
      },
      {
        name: "Beschreibung",
        icon_url: "/img/description.svg",
      },
    ];
    return { orderProcess };
  },
});
</script>
