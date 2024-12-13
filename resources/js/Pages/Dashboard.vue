<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import HeroLayout from "@/HeroLayout.vue";
import ListLayout from "@/ListLayout.vue";
import Footer from "@/Footer.vue";
</script>

<template>
  <Head title="HomePage" />

  <AuthenticatedLayout>

        <HeroLayout />
        <ListLayout />
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg"></div>
      </div>
    </div>
  </AuthenticatedLayout>
    <Footer />
</template>
