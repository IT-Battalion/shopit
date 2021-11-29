<template>
  <div class="w-full">
    <div
      class="max-w-2xl px-4 py-16 mx-auto sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8"
    >
      <h2 class="text-2xl font-extrabold tracking-tight text-white">
        Kategoriename
      </h2>

      <div
        class="grid grid-cols-1 mt-6  gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8"
      >
        <div
          v-for="product in products"
          :key="product.id"
          class="relative group"
        >
          <div
            class="w-full overflow-hidden rounded-md  bg-backgroundColor min-h-80 aspect-w-1 aspect-h-1 group-hover:opacity-75 lg:h-80 lg:aspect-none"
          >
            <img
              :src="product.imageSrc"
              :alt="product.imageAlt"
              class="object-cover object-center w-full h-full  lg:w-full lg:h-full"
            />
          </div>
          <div class="flex justify-between mt-4">
            <div>
              <h3 class="text-sm text-gray-700">
                <a :href="product.href">
                  <span aria-hidden="true" class="absolute inset-0" />
                  {{ product.name }}
                </a>
              </h3>
              <p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>
            </div>
            <p class="text-sm font-medium text-gray-900">{{ product.price }}</p>
            <button
              class="w-auto px-4 py-2 bg-white rounded hover:bg-gray-300"
              type="button"
            >
              <svg
                fill="#000"
                width="100pt"
                height="100pt"
                version="1.1"
                viewBox="0 0 100 100"
                xmlns="http://www.w3.org/2000/svg"
                class="object-scale-down h-8 mr-4"
              >
                <g>
                  <path
                    d="m48.359 42.656c-0.09375-0.89062-0.15625-1.7969-0.15625-2.7188s0.046875-1.8438 0.15625-2.75h-25.078l-2.125-8.0625c-0.3125-1.2031-1.4062-2.0312-2.6406-2.0312h-9.5312c-1.5156 0-2.7344 1.2188-2.7344 2.7344s1.2188 2.7344 2.7344 2.7344h7.4219l2.125 8.0625s0 0.015625 0.015625 0.015625l6.6406 25.609c0.3125 1.2031 1.4062 2.0312 2.6562 2.0312h0.32812c-0.39062 0.98438-0.60938 2.0469-0.60938 3.1719 0 4.75 3.875 8.625 8.625 8.625s8.625-3.875 8.625-8.625c0-1.125-0.21875-2.1875-0.60938-3.1719h6.5c-0.39062 0.98438-0.60938 2.0469-0.60938 3.1719 0 4.75 3.875 8.625 8.625 8.625s8.625-3.875 8.625-8.625c0-1.125-0.21875-2.1875-0.60938-3.1719h0.32812c1.25 0 2.3438-0.82812 2.6562-2.0312l0.28125-1.1094c-2.6562-0.375-5.1719-1.1875-7.4844-2.3281-7.7031-3.75-13.219-11.281-14.156-20.156zm-9.0156 28.812c0 1.7344-1.4062 3.1562-3.1562 3.1562-1.7344 0-3.1562-1.4219-3.1562-3.1562 0-1.75 1.4219-3.1719 3.1562-3.1719 1.75 0 3.1562 1.4219 3.1562 3.1719zm22.516 0c0 1.7344-1.4219 3.1562-3.1562 3.1562-1.75 0-3.1562-1.4219-3.1562-3.1562 0-1.75 1.4062-3.1719 3.1562-3.1719 1.7344 0 3.1562 1.4219 3.1562 3.1719z"
                  />
                  <path
                    d="m73.703 19.906c-11.047 0-20.031 9-20.031 20.047s8.9844 20.031 20.031 20.031c11.062 0 20.031-8.9844 20.031-20.031 0-11.062-8.9688-20.047-20.031-20.047zm5.9531 22.766h-3.2188v3.2188c0 1.5-1.2188 2.7344-2.7344 2.7344-1.5 0-2.7344-1.2344-2.7344-2.7344v-3.2188h-3.2031c-1.5156 0-2.7344-1.2344-2.7344-2.7344 0-1.5156 1.2188-2.7344 2.7344-2.7344h3.2031v-3.2188c0-1.5156 1.2344-2.7344 2.7344-2.7344 1.5156 0 2.7344 1.2188 2.7344 2.7344v3.2188h3.2188c1.5156 0 2.7344 1.2188 2.7344 2.7344-0.015625 1.5-1.2188 2.7344-2.7344 2.7344z"
                  />
                </g>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
const products = [
  {
    id: 1,
    name: "Basic Tee",
    href: "#",
    imageSrc:
      "https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg",
    imageAlt: "Front of men's Basic Tee in black.",
    price: "$35",
    color: "Black",
  },
  {
    id: 2,
    name: "Basic Tee",
    href: "#",
    imageSrc:
      "https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg",
    imageAlt: "Front of men's Basic Tee in black.",
    price: "$35",
    color: "Black",
  },
  {
    id: 3,
    name: "Basic Tee",
    href: "#",
    imageSrc:
      "https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg",
    imageAlt: "Front of men's Basic Tee in black.",
    price: "$35",
    color: "Black",
  },
  {
    id: 4,
    name: "Basic Tee",
    href: "#",
    imageSrc:
      "https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg",
    imageAlt: "Front of men's Basic Tee in black.",
    price: "$35",
    color: "Black",
  },
  {
    id: 5,
    name: "Basic Tee",
    href: "#",
    imageSrc:
      "https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg",
    imageAlt: "Front of men's Basic Tee in black.",
    price: "$35",
    color: "Black",
  },
  {
    id: 6,
    name: "Basic Tee",
    href: "#",
    imageSrc:
      "https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg",
    imageAlt: "Front of men's Basic Tee in black.",
    price: "$35",
    color: "Black",
  },
  {
    id: 7,
    name: "Basic Tee",
    href: "#",
    imageSrc:
      "https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg",
    imageAlt: "Front of men's Basic Tee in black.",
    price: "$35",
    color: "Black",
  },
  {
    id: 8,
    name: "Basic Tee",
    href: "#",
    imageSrc:
      "https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg",
    imageAlt: "Front of men's Basic Tee in black.",
    price: "$35",
    color: "Black",
  },
  // More products...
];

export default {
  setup() {
    return {
      products,
    };
  },
};
</script>