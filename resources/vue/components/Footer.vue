<template>
  <div class="z-20 w-full mt-10 mb-24 text-white left-52 sm:mt-48 sm:mb-0">
    <div class="px-5 pb-12 xl:px-30 lg:px-15 md:px-5 sm:px-0">
      <div
        class="flex flex-col justify-start w-full pt-12 space-y-2 sm:flex-row"
      >
        <div
          class="
            grid
            w-full
            grid-cols-3 grid-rows-1
            gap-1
            pr-6
            space-y-4
            sm:w-1/4
          "
        >
          <img class="w-16 h-16" src="/img/lernenImAufbruch.svg" />
          <p class="flex flex-row opacity-60">
            <HomeIcon class="w-5 h-5 pr-1" />
            Wexstraße 19-23 1200 Wien
          </p>
        </div>
        <div class="flex flex-col w-full space-y-4 sm:w-2/5">
          <a class="flex flex-row text-lg font-medium opacity-60">Kontakt</a>
          <a
            href="mailto:info@shopit.tgm.ac.at"
            class="
              flex flex-row
              underline
              opacity-60
              hover:opacity-100
              decoration-solid
            "
            >info@shopit.tgm.ac.at</a
          >
          <a
            href="mailto:info@LernenImAufbruch.at"
            class="
              flex flex-row
              underline
              opacity-60
              hover:opacity-100
              decoration-solid
            "
            >info@LernenImAufbruch.at</a
          >
        </div>
        <div class="flex flex-col w-full space-y-4 sm:w-1/5">
          <a class="flex flex-row mt-4 text-lg font-medium opacity-60 sm:mt-0"
            >Links</a
          >
          <a
            href="https://www.tgm.ac.at/tagesschule/"
            class="
              flex flex-row
              underline
              opacity-60
              hover:opacity-100
              decoration-solid
            "
            >TGM HIT
            <ExternalLinkIcon class="w-5 h-5 pl-1" />
          </a>
          <a
            href="https://lernenimaufbruch.at/impressum.html"
            class="
              flex flex-row
              underline
              opacity-60
              hover:opacity-100
              decoration-solid
            "
            >Impressum
            <ExternalLinkIcon class="w-5 h-5 pl-1" />
          </a>
        </div>
        <div class="flex flex-col w-full space-y-4 sm:w-1/5">
          <a class="flex flex-row mt-4 text-lg font-medium opacity-60 sm:mt-0"
            >Mentions</a
          >
          <router-link
            :to="{ name: 'credits' }"
            tag="button"
            class="
              flex flex-row
              underline
              opacity-60
              hover:opacity-100
              decoration-solid
            "
          >
            Icon Credits
            <ExternalLinkIcon class="w-5 h-5 pl-1" />
          </router-link>
          <router-link
            :to="{ name: 'contributors' }"
            class="
              flex flex-row
              underline
              opacity-60
              hover:opacity-100
              decoration-solid
            "
            >Contributors
            <ExternalLinkIcon class="w-5 h-5 pl-1" />
          </router-link>
        </div>
      </div>
      <div class="pt-2 opacity-60">
        <p>© Lernen im Aufbruch - Alle Rechte vorbehalten</p>
      </div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import { ExternalLinkIcon, HomeIcon } from "@heroicons/vue/solid";

export default defineComponent({
  components: {
    HomeIcon,
    ExternalLinkIcon,
  },
});
</script>
