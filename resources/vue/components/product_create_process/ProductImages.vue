<template>
  <div>
    <div class="mx-5 mt-20 md:mx-20">
      <p class="text-white text-md mb-3">Die hochgeladenen Bilder können umgeordnet werden. Das erste Bild wird als Thumbnail für das Produkt verwendet.</p>
      <pond
        ref="uploader"
        :server="server"
        accepted-file-types="image/jpeg, image/png"
        allow-multiple="true"
        label-idle="Hier klicken um Bilder hochzuladen!"
        name="uploadImages"
        allow-reorder="true"
        required="true"
        force-revert="true"
        drop-on-page="true"
        v-bind:files="myFiles"
        @initfile="startProgress"
        @processfilerevert="startProgress"
        @processfiles="endProgress"
        @removefile="endProgress"
        @error="error = 'Es gab einen Fehler bei der Verarbeitung eines oder mehrerer Bilder!'"
      />
      <p class="text-base text-red-400">{{error}}</p>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "@vue/runtime-core";

import vueFilePond, {VueFilePondComponent} from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import {FilePond, Status} from "filepond";
import {endLoad, initLoad} from "../../loader";

const Pond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview) as VueFilePondComponent;

export default defineComponent({
  name: "ProductImages",
  props: {
    'images': {
      type: Array,
      required: true,
    }
  },
  emits: ['update:images'],
  setup() {
    return {
      console,
    };
  },
  data() {
    let resolve:undefined|((value: void)=>void), reject:undefined|((reason?: any)=>void);
    let promise = new Promise<void>((res, rej) => {
      rej();
      resolve = res;
      reject = rej;
    }).catch(()=>{});

    return {
      myFiles: [] as string[],
      server: {
        url: "/api/admin/productImage",
        headers: {
          "X-CSRF-TOKEN": window.document.querySelector("meta[name=\"csrf-token\"]")?.getAttribute("content")
        }
      },
      pond: {} as FilePond, //import {FilePond} from './filepond'
      error: "",
      promise,
      resolve,
      reject,
    };
  },
  components: {
    Pond,
  },
  async mounted() {
    this.pond = (this.$refs.uploader as any)._pond as FilePond;
  },
  methods: {
    startProgress() {
      initLoad();
      let resolve, reject;
      this.promise = new Promise((res, rej) => {
        resolve = res;
        reject = rej;
      });
      this.resolve = resolve;
      this.reject = reject;
    },
    endProgress() {
      endLoad();
      this.$emit('update:images', this.pond.getFiles().map((file)=>file.serverId));
      if (this.pond.status === Status.READY && this.resolve) {
        this.resolve();
      } else {
        if (this.reject) {
          this.reject();
        } else {
          this.promise = Promise.reject();
        }
      }
    },
    async validate() {
      this.pond.files.push()
      switch (this.pond.status) {
        case Status.READY:
          return Promise.resolve();
        case Status.EMPTY:
          this.error = "Es wurden noch keine Bilder hochgeladen. Bitte laden Sie Bilder hoch.";
          return Promise.reject();
        case Status.ERROR:
          this.error = "Es gab einen Fehler bei der Verarbeitung eines oder mehrerer Bilder.";
          return Promise.reject();
        case Status.BUSY:
          this.error = "Die Bilder werden noch verarbeitet. Sie werden weitergeleitet sobald die Bilder verarbeitet wurden.";
          return this.promise.then(() => {this.error = ''});
      }
    },
  },
});
</script>

<style src="../../../../node_modules/filepond/dist/filepond.min.css"/>
<style src="../../../../node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"/>
