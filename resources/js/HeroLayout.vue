<script setup lang="ts">
import ApplicationBackground from "./Components/ApplicationBackground.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

</script>

<template>
  <div
    class="relative pt-48 pb-12 bg-black xl:pt-60 sm:pb-16 lg:pb-32 xl:pb-48 2xl:pb-56"
  >
    <header class="absolute inset-x-0 top-0 z-10 py-8 xl:py-12">
      <div class="px-6 mx-auto sm:px-8 lg:px-12 max-w-7xl">
        <div class="flex items-center justify-between">
          <div class="flex flex-shrink-0">
            <!-- <a href="#" title="BakerStreet" class="inline-flex rounded-md focus:outline-none focus:ring-2 focus:ring-offset-4 focus:ring-offset-secondary focus:ring-primary">
                        <ApplicationLogo
                                        class="w-auto h-8"
                                    />
                    </a> -->
          </div>

          <div class="md:hidden">
            <button
              type="button"
              class="p-2 -m-2 transition-all duration-200 rounded-full text-white focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary focus:ring-offset-secondary"
            >
              <svg
                class="w-6 h-6"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
              </svg>
            </button>
          </div>

          
        </div>
      </div>
    </header>

    <div class="absolute inset-0">
      <ApplicationBackground
        class="object-cover brightness-110 backdrop-blur-sm w-full h-full"
      />
    </div>

    <div class="relative">
      <div class="px-6 mx-auto sm:px-8 lg:px-12 max-w-7xl">
        <div
          class="max-w-xl mx-auto text-center p-2 rounded-md bg-slate-50 opacity-70 shadow-lg shadow-cyan-500/50"
        >
          <h1 class="tracking-tighter text-white">
            <span
              class="font-serif italic font-normal text-7xl tracking-widest text-green-700"
              >GLMA Agnecy</span
            ><br />
          </h1>
          <p class="mt-5 font-sans text-base text-rose-950 font-semibold">
            GLMA Agency is one of the leading digital marketing agencies in the United
            Arab Emirates that delivers results. We provide services to a vast number of
            companies in all niches within the UAE and abroad.
          </p>
        </div>
      </div>
    </div>

 
  </div>
</template>
