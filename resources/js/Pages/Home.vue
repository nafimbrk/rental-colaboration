<script setup>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "../Components/Layout/Layout.vue";
import Chatbot from "../Components/Chatbot.vue";
import { route } from "ziggy-js";
</script>

<template>
  <Layout>
    <Head title="Home" />

    <section
  class="h-[90vh] flex items-center justify-center bg-gradient-to-b from-blue-50 to-white px-6 pt-10"
>
  <div class="text-center max-w-3xl -mt-10">
    <!-- Hero Text -->
    <h1 class="text-5xl md:text-6xl font-extrabold text-gray-800 leading-tight mb-6">
      <span class="text-blue-600">Rental MobilKu</span><br />
      Temukan Mobil Impianmu 🚗
    </h1>

    <!-- Deskripsi -->
    <p class="text-gray-600 text-lg md:text-xl leading-relaxed mb-8">
      Nikmati kemudahan menyewa mobil pilihanmu dengan cepat dan aman.
      Kami menyediakan berbagai jenis mobil untuk perjalanan liburan, bisnis, hingga harian.
    </p>

    <!-- Tombol CTA -->
    <div class="flex flex-col sm:flex-row justify-center gap-4">
      <Link
        :href="route('car.index')"
        class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all duration-300"
      >
        🚘 Lihat Daftar Mobil
      </Link>

      <Link
        :href="route('about')"
        class="bg-white border border-gray-300 text-gray-700 px-8 py-3 rounded-xl font-semibold hover:bg-gray-50 hover:shadow-md transition-all duration-300"
      >
        Tentang Kami
    </Link>
    </div>
  </div>
</section>

<Chatbot/>

  </Layout>
</template>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in {
  animation: fade-in 1s ease-out forwards;
}
</style>
