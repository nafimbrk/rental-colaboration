<script setup>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "../Components/Layout/Layout.vue";
import { route } from "ziggy-js";
</script>

<template>
  <Layout>
    <Head title="Kontak Kami" />

    <!-- Hero -->
    <section class="bg-gradient-to-b from-blue-50 to-white py-16 px-6 text-center">
      <h1 class="text-4xl md:text-5xl font-extrabold text-blue-700 mb-4">
        Hubungi Kami
      </h1>
      <p class="text-gray-600 text-lg max-w-2xl mx-auto">
        Kami siap membantu Anda! Silakan hubungi kami melalui formulir di bawah ini
        atau datang langsung ke kantor kami.
      </p>
    </section>

    <!-- Konten utama -->
    <section class="max-w-5xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-10">
      <!-- Form Kontak -->
      <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>
        <form class="space-y-5">
          <div>
            <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
            <input
              type="text"
              placeholder="Masukkan nama Anda"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
            />
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-2">Email</label>
            <input
              type="email"
              placeholder="Masukkan email Anda"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
            />
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-2">Pesan</label>
            <textarea
              rows="4"
              placeholder="Tulis pesan Anda di sini..."
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
            ></textarea>
          </div>

          <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md hover:bg-blue-700 transition"
          >
            Kirim Pesan
          </button>
        </form>
      </div>

      <!-- Informasi Kontak -->
      <div class="bg-blue-50 rounded-2xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kami</h2>

        <div class="space-y-5 text-gray-700">
          <p>
            <span class="font-semibold text-blue-600">Alamat:</span><br />
            Jl. Raya Merdeka No. 45, Lamongan, Indonesia
          </p>

          <p>
            <span class="font-semibold text-blue-600">Telepon:</span><br />
            +62 812-3456-7890
          </p>

          <p>
            <span class="font-semibold text-blue-600">Email:</span><br />
            support@rentalmobilku.com
          </p>

          <p>
            <span class="font-semibold text-blue-600">Jam Operasional:</span><br />
            Senin – Minggu: 08.00 – 21.00
          </p>
        </div>

        <div class="mt-8">
          <img
  src="https://images.unsplash.com/photo-1664783856972-ac9922d7b2d3?fm=jpg&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Zm9ydHVuZXJ8ZW58MHx8MHx8fDA%3D&ixlib=rb-4.1.0&q=60&w=3000"
  alt="Kantor Kami"
  class="rounded-xl shadow-md object-cover object-[center_87%] w-full h-56"
/>


        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 px-6 text-center">
      <h2 class="text-3xl font-bold text-gray-800 mb-4">
        Ingin langsung menyewa mobil?
      </h2>
      <p class="text-gray-600 mb-6">
        Pilih mobil impian Anda sekarang dan nikmati perjalanan tanpa batas!
      </p>
      <Link
        :href="route('car.index')"
        class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold shadow-md hover:bg-blue-700 transition"
      >
        🚗 Lihat Daftar Mobil
      </Link>
    </section>
  </Layout>
</template>
