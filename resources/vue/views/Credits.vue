<template>
  <h1 class="w-full my-10 text-5xl font-bold text-center text-white uppercase">
    Credits
  </h1>
  <div
    v-for="credit in credits"
    :key="credit.iconLink"
    :name="credit.iconName"
    class="flex flex-col w-full text-center justify-items-center"
  >
    <div class="my-5 text-white">
      "<a :href="credit.iconLink" class="underline">{{ credit.iconName }}</a
      >" icon by
      <a :href="credit.creatorLink" class="underline">{{ credit.creator }}</a>
      from
      <a href="https://thenounproject.com/" class="underline"
        >the Noun Project</a
      >.
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
  setup() {
    const credits = [
      {
        iconName: "Check",
        iconLink: "https://thenounproject.com/icon/check-3496109/",
        creator: "Nasik Lababan",
        creatorLink: "https://thenounproject.com/nasik/",
      },
      {
        iconName: "X",
        iconLink: "https://thenounproject.com/icon/x-2172392/",
        creator: "Lina",
        creatorLink: "https://thenounproject.com/sumarlina1708/",
      },
      {
        iconName: "Info",
        iconLink: "https://thenounproject.com/icon/info-1736324/",
        creator: "Xela Ub",
        creatorLink: "https://thenounproject.com/xela./",
      },
      {
        iconName: "add cart",
        iconLink: "https://thenounproject.com/andikaastro01/",
        creator: "andika",
        creatorLink: "https://thenounproject.com/xela./",
      },
      {
        iconName: "cart",
        iconLink: "https://thenounproject.com/icon/cart-1832893/",
        creator: "Nanda Ririz",
        creatorLink: "https://thenounproject.com/nandaririz13/",
      },
      {
        iconName: "bin",
        iconLink: "https://thenounproject.com/icon/bin-2034046/",
        creator: "Alice Design",
        creatorLink: "https://thenounproject.com/rose-alice-design/",
      },
      {
        iconName: "write",
        iconLink: "https://thenounproject.com/icon/write-4525486/",
        creator: "Saktianto Adhi Pambudi",
        creatorLink: "https://thenounproject.com/tanahbasah/",
      },
      {
        iconName: "Arrow",
        iconLink: "https://thenounproject.com/icon/arrow-1776263/",
        creator: "Three Six Five",
        creatorLink: "https://thenounproject.com/365/",
      },
      {
        iconName: "profile",
        iconLink: "https://thenounproject.com/icon/profile-4530368/",
        creator: "Saideep Karipalli",
        creatorLink: "https://thenounproject.com/saideep/",
      },
      {
        iconName: "Log Out",
        iconLink: "https://thenounproject.com/icon/log-out-2431969/",
        creator: "Susannanova",
        creatorLink: "https://thenounproject.com/susannanova/",
      },
      {
        iconName: "Home",
        iconLink: "https://thenounproject.com/icon/home-3367736/",
        creator: "HideMaru",
        creatorLink: "https://thenounproject.com/hiddemaru/",
      },
      {
        iconName: "Price Tag",
        iconLink: "https://thenounproject.com/icon/price-tag-2388839/",
        creator: "Yo! Baba",
        creatorLink: "https://thenounproject.com/vectormarket01/",
      },
      {
        iconName: "profile",
        iconLink: "https://thenounproject.com/icon/profile-405171/",
        creator: "Nicolas Morand",
        creatorLink: "https://thenounproject.com/n.morand/",
      },
      {
        iconName: "bill",
        iconLink: "https://thenounproject.com/icon/bill-4523032/",
        creator: "Yogi Aprelliyanto",
        creatorLink: "https://thenounproject.com/yogiaprelliyanto/",
      },
      {
        iconName: "History",
        iconLink: "https://thenounproject.com/icon/history-4530622/",
        creator: "Athok",
        creatorLink: "https://thenounproject.com/athok.art/",
      },
      {
        iconName: "Shirt",
        iconLink: "https://thenounproject.com/icon/shirt-4525011/",
        creator: "Saepul Nahwan",
        creatorLink: "https://thenounproject.com/saepulnahwan23/",
      },
      {
        iconName: "Category",
        iconLink: "https://thenounproject.com/icon/category-2120040/",
        creator: "Fahmi",
        creatorLink: "https://thenounproject.com/GamerGanteng/",
      },
      {
        iconName: "Package",
        iconLink: "https://thenounproject.com/icon/package-1886048/",
        creator: "shashank singh",
        creatorLink: "https://thenounproject.com/rshashank19/",
      },
      {
        iconName: "User",
        iconLink: "https://thenounproject.com/icon/user-4530585/",
        creator: "Athok",
        creatorLink: "https://thenounproject.com/athok.art/",
      },
      {
        iconName: "Coupon",
        iconLink: "https://thenounproject.com/icon/coupon-1569400/",
        creator: "Roundicons.com",
        creatorLink: "https://thenounproject.com/roundicons/",
      },
      {
        iconName: "Image",
        iconLink: "https://thenounproject.com/icon/image-4512783/",
        creator: "Jatu Kumala",
        creatorLink: "https://thenounproject.com/sarijk/",
      },
      {
        iconName: "price",
        iconLink: "https://thenounproject.com/icon/price-3806993/",
        creator: "Kmg Design",
        creatorLink: "https://thenounproject.com/kmgdesignid/",
      },
      {
        iconName: "Edit block attributes",
        iconLink:
          "https://thenounproject.com/icon/edit-block-attributes-662385/",
        creator: "Creaticca Creative Agency",
        creatorLink: "https://thenounproject.com/creaticca/",
      },
      {
        iconName: "description",
        iconLink: "https://thenounproject.com/icon/description-4518375/",
        creator: "Gregor Cresnar",
        creatorLink: "https://thenounproject.com/grega.cresnar/",
      },
      {
        iconName: "webshop",
        iconLink: "https://thenounproject.com/icon/webshop-3215856/",
        creator: "Vectors Point",
        creatorLink: "https://thenounproject.com/vectorspoint/",
      },
      {
        iconName: "paying",
        iconLink: "https://thenounproject.com/icon/paying-4279707/",
        creator: "ToZIcon",
        creatorLink: "https://thenounproject.com/tozicon/",
      },
      {
        iconName: "Waiting",
        iconLink: "https://thenounproject.com/icon/waiting-3053732/",
        creator: "Adrien Coquet",
        creatorLink: "https://thenounproject.com/coquet_adrien/",
      },
      {
        iconName: "pick up",
        iconLink: "https://thenounproject.com/icon/pick-up-4058544/",
        creator: "Adrien Coquet",
        creatorLink: "https://thenounproject.com/coquet_adrien/",
      },
      {
        iconName: "done",
        iconLink: "https://thenounproject.com/icon/done-1482828/",
        creator: "Acharyas",
        creatorLink: "https://thenounproject.com/putturdamuttu17/",
      },
      {
        iconName: "External Link",
        iconLink: "https://thenounproject.com/icon/external-link-4132385/",
        creator: "IcoMoon",
        creatorLink: "https://thenounproject.com/icomoonpack/",
      },
      {
        iconName: "add",
        iconLink: "https://thenounproject.com/icon/add-2419031/",
        creator: "vectlab",
        creatorLink: "https://thenounproject.com/vectlabmail/",
      },
      {
        iconName: "dashboard",
        iconLink: "https://thenounproject.com/icon/dashboard-2077912/",
        creator: "shashank singh",
        creatorLink: "https://thenounproject.com/rshashank19/",
      },
      {
        iconName: "edit",
        iconLink: "https://thenounproject.com/icon/edit-4518321/",
        creator: "Gregor Cresnar",
        creatorLink: "https://thenounproject.com/grega.cresnar/",
      },
      {
        iconName: "Upload",
        iconLink: "https://thenounproject.com/icon/upload-4526942/",
        creator: "Widyatmoko",
        creatorLink: "https://thenounproject.com/yogs144/",
      },
      {
        iconName: "Lock",
        iconLink: "https://thenounproject.com/icon/lock-4530345/",
        creator: "Saideep Karipalli",
        creatorLink: "https://thenounproject.com/saideep/",
      },
    ];
    return { credits };
  },
});
</script>