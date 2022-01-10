<template>
  <div class="w-full text-white z-20 left-52 mt-48">
    <div class="xl:px-40 pb-12 lg:px-20 md:px-10 sm:px-5 px-10">
      <div
        class="w-full pt-12 flex flex-col sm:flex-row space-y-2 justify-start"
      >
        <div
          class="
            w-full
            sm:w-2/5
            pr-6
            grid grid-cols-3 grid-rows-1
            gap-1
            space-y-4
          "
        >
          <img src="/img/lernenImAufbruch.svg" class="h-16 w-16" />
          <p class="opacity-60 flex flex-row">
            <HomeIcon class="w-5 h-5 pr-1" />Wexstraße 19-23 1200 Wien
          </p>
        </div>
        <div class="w-full sm:w-2/5 flex flex-col space-y-4">
          <a class="opacity-60 flex flex-row"
            >Kontakt<AnnotationIcon class="w-5 h-5 pl-1"
          /></a>
          <a
            href="mailto:info@LernenImAufbruch.at"
            class="
              opacity-60
              hover:opacity-100
              flex flex-row
              underline
              decoration-solid
            "
            >info@LernenImAufbruch.at<MailIcon class="w-5 h-5 pl-1" />
          </a>
        </div>
        <div class="w-full sm:w-1/5 flex flex-col space-y-4">
          <a class="opacity-60 flex flex-row"
            >Links<LinkIcon class="w-5 h-5 pl-1"
          /></a>
          <a
            href="https://www.tgm.ac.at/tagesschule/"
            class="
              opacity-60
              hover:opacity-100
              flex flex-row
              underline
              decoration-solid
            "
            >TGM HIT<ExternalLinkIcon class="w-5 h-5 pl-1"
          /></a>
          <a
            href="https://lernenimaufbruch.at/impressum.html"
            class="
              opacity-60
              hover:opacity-100
              flex flex-row
              underline
              decoration-solid
            "
            >Impressum<ExternalLinkIcon class="w-5 h-5 pl-1"
          /></a>
        </div>
      </div>
      <div class="opacity-60 pt-2">
        <p>© Lernen im Aufbruch - Alle Rechte vorbehalten</p>
      </div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "@vue/runtime-core";
import {
  HomeIcon,
  ExternalLinkIcon,
  MailIcon,
  AnnotationIcon,
  LinkIcon,
} from "@heroicons/vue/solid";
export default defineComponent({
  components: {
    HomeIcon,
    ExternalLinkIcon,
    MailIcon,
    AnnotationIcon,
    LinkIcon,
  },
});
</script>
