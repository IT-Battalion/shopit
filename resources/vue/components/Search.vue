<template>
  <form method="GET">
    <div class="text-gray-600 focus-within:text-gray-400">
      <span class="absolute inset-y-0 left-0 flex items-center pl-2">
        <button
          type="submit"
          class="p-1 focus:outline-none focus:shadow-outline"
        >
          <svg
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            class="w-6 h-6"
          >
            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </button>
      </span>
      <input
        type="search"
        name="q"
        class="py-2 pl-10 text-sm text-white bg-gray-900 rounded-md  focus:outline-none focus:bg-white focus:text-gray-900"
        placeholder="Search..."
        autocomplete="off"
      />
    </div>
  </form>
</template>