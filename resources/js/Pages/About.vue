<script setup>
import { Head } from "@inertiajs/vue3";
import Layout from "../Components/Layout/Layout.vue";
import { route } from "ziggy-js";
</script>

<template>
  <Layout>
    <Head title="Tentang Kami" />

    <!-- Hero / Header -->
    <section class="bg-gradient-to-b from-blue-50 to-white py-16 px-6 text-center">
      <h1 class="text-4xl md:text-5xl font-extrabold text-blue-700 mb-4">
        Tentang Kami
      </h1>
      <p class="text-gray-600 text-lg max-w-2xl mx-auto">
        Kenali lebih dekat tentang <span class="font-semibold text-blue-600">Rental MobilKu</span> —
        layanan penyewaan mobil terpercaya yang siap menemani perjalanan Anda.
      </p>
    </section>

    <!-- Konten utama -->
    <section class="max-w-5xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-10 items-center">
      <!-- Gambar -->
<div class="flex justify-center">
  <img
    src="https://images.unsplash.com/photo-1748215210939-ad8b6c8c086d?fm=jpg&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8dG95b3RhJTIwaW5ub3ZhfGVufDB8fDB8fHww&ixlib=rb-4.1.0&q=60&w=3000"
    alt="Tentang Kami"
    class="rounded-2xl shadow-lg w-4/5 md:w-full object-cover"
  />
</div>


      <!-- Teks -->
      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">
          Siap Mengantarkan Anda ke Tujuan dengan Nyaman 🚗
        </h2>
        <p class="text-gray-600 leading-relaxed mb-4">
          Sejak berdiri pada tahun <strong>2024</strong>, Rental MobilKu berkomitmen memberikan
          pengalaman terbaik dalam penyewaan mobil. Kami menyediakan berbagai jenis mobil — mulai
          dari city car, MPV, hingga SUV — untuk keperluan pribadi, keluarga, maupun bisnis.
        </p>
        <p class="text-gray-600 leading-relaxed mb-4">
          Dengan sistem pemesanan yang mudah dan pelayanan yang ramah, kami ingin menjadi pilihan
          utama Anda dalam setiap perjalanan.
        </p>
        <p class="text-gray-600 leading-relaxed">
          Visi kami adalah <span class="text-blue-600 font-semibold">“Menyediakan layanan rental mobil yang cepat, aman, dan terpercaya untuk semua kalangan.”</span>
        </p>
      </div>
    </section>

    <!-- Nilai perusahaan -->
    <section class="bg-blue-50 py-16 px-6">
      <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-10">Nilai Utama Kami</h2>

        <div class="grid md:grid-cols-3 gap-8">
          <div class="bg-white shadow-md rounded-2xl p-6 hover:shadow-lg transition">
            <span class="material-icons text-blue-600 text-4xl mb-3">verified_user</span>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Keamanan</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
              Semua mobil kami selalu dalam kondisi prima dan rutin diservis untuk memastikan keamanan perjalanan Anda.
            </p>
          </div>

          <div class="bg-white shadow-md rounded-2xl p-6 hover:shadow-lg transition">
            <span class="material-icons text-blue-600 text-4xl mb-3">speed</span>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Kecepatan</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
              Proses pemesanan cepat dan responsif. Hanya butuh beberapa klik untuk mendapatkan mobil impian Anda.
            </p>
          </div>

          <div class="bg-white shadow-md rounded-2xl p-6 hover:shadow-lg transition">
            <span class="material-icons text-blue-600 text-4xl mb-3">emoji_people</span>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Kepuasan</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
              Kami menempatkan kepuasan pelanggan sebagai prioritas utama. Layanan kami tersedia setiap saat.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 px-6 text-center">
      <h2 class="text-3xl font-bold text-gray-800 mb-4">Siap untuk bepergian?</h2>
      <p class="text-gray-600 mb-6">
        Temukan mobil terbaik sesuai kebutuhan Anda dan nikmati perjalanan tanpa batas bersama kami.
      </p>
      <Link
        :href="route('car.index')"
        class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold shadow-md hover:bg-blue-700 transition"
      >
        🚘 Lihat Daftar Mobil
      </Link>
    </section>
  </Layout>
</template>
