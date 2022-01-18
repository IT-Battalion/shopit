<template>
  <form action="GET">
    <label class="mb-3 mr-3 text-base text-gray-300">{{ labelName }}</label>
    <div id="whoobe-7izhv" class="flex flex-row">
      <span
        id="whoobe-plfl9"
        class="flex items-center justify-center w-10 h-10 text-2xl text-gray-400 border border-r-0 rounded-l-lg  z-highest"
        mode="render"
        block=""
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          aria-hidden="true"
          role="img"
          width="1em"
          height="1em"
          preserveAspectRatio="xMidYMid meet"
          viewBox="0 0 26 26"
          class="iconify iconify--wpf"
        >
          <path
            d="M16.563 15.9c-.159-.052-1.164-.505-.536-2.414h-.009c1.637-1.686 2.888-4.399 2.888-7.07c0-4.107-2.731-6.26-5.905-6.26c-3.176 0-5.892 2.152-5.892 6.26c0 2.682 1.244 5.406 2.891 7.088c.642 1.684-.506 2.309-.746 2.397c-3.324 1.202-7.224 3.393-7.224 5.556v.811c0 2.947 5.714 3.617 11.002 3.617c5.296 0 10.938-.67 10.938-3.617v-.811c0-2.228-3.919-4.402-7.407-5.557z"
            fill="currentColor"
          ></path>
        </svg>
      </span>
      <input
        class="w-full pl-1 text-white border rounded-r-lg outline-none  bg-elevatedColor focus:ring-1 ring-blue-400"
      />
    </div>
  </form>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  props: {
    labelName: String,
    iconName: String,
  },
});
</script>