<template>
  <mq-responsive target="lg+">
    <div class="flex flex-row items-center justify-center w-full gap-5 h-28">
      <template v-for="(progress, index) in productProgressSteps" :key="progress.name">
        <button class="flex flex-col items-center transition-opacity transition-size" :disabled="index > latestStep + 1" @click="$emit('changeStep', index)">
          <img :src="progress.icon_url" :alt="progress.name" class="transition-size transition-opacity ease-overshoot" :class="imageClasses(index)" />
          <span class="mt-3 text-base text-center transition-opacity transition-size text-white" :class="textClasses(index)">{{
            progress.name
          }}</span>
        </button>
        <span
          class="rounded-full bg-white transition-opacity transition-size w-16"
          :class="index > latestStep - 1 ? 'h-1 opacity-80' : 'h-2'"
          v-if="index < productProgressSteps.length - 1"
        />
      </template>
    </div>
  </mq-responsive>
  <mq-responsive target="md-">
    <div class="flex flex-col items-center gap-5 ml-auto mr-0">
      <template v-for="process in productProgressSteps" :key="process.name">
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
import {defineComponent} from "@vue/runtime-core";
import Log from "../Log.vue";

export default defineComponent({
  name: "ProductProgressBar",
  components: {
    Log,
  },
  props: {
    step: {
      type: Number,
      required: true,
    },
    latestStep: {
      type: Number,
      required: true,
    },
  },
  emits: ['changeStep'],
  setup() {
    const productProgressSteps = [
      {
        name: "Preis & Titel",
        icon_url: "/img/titelPrice.svg",
      },
      {
        name: "Bilddateien",
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
    return { productProgressSteps };
  },
  methods: {
    imageClasses(current: number) {
      if (this.latestStep < current)
        return "w-8 h-8 opacity-80";
      else if (this.step === current)
        return "w-20 h-20";
      else
        return "w-8 h-8";
    },
    textClasses(current: number) {
      if (this.latestStep < current)
        return "text-sm opacity-80";
      else if (this.step === current)
        return "text-lg";
      else
        return "test-sm";
    },
  },
});
</script>
