<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import LayoutAdmin from '../../Components/Layout/LayoutAdmin.vue';
import { computed } from 'vue';
import { route } from 'ziggy-js';

const props = defineProps({
  totalCar: Number,
  totalCustomer: Number,
  totalTransaction: Number,
  totalOperator: Number,
  recentTransactions: Array,
  totalMaintenance: Number
})

const page = usePage()
const user = computed(() => page.props.auth.user)

const formatRupiah = (angka) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0, // hilangin nol dibelakang
    maximumFractionDigits: 0,
  }).format(angka);
};
</script>

<template>
  <LayoutAdmin>

    <Head title="Dashboard" />
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
      <div class="p-6">
        <!-- Card Statistik -->
        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center justify-between">
          <!-- Kiri (teks) -->
          <div>
            <h2 class="text-lg font-semibold text-gray-600">Total Mobil</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ totalCar }}</p>
          </div>

          <!-- Kanan (ikon) -->
          <div class="bg-blue-100 p-4 rounded-full">
            <span class="material-icons text-blue-600 text-4xl">directions_car</span>
          </div>
        </div>
      </div>
      <div class="p-6">
        <!-- Card Statistik -->
        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center justify-between">
          <!-- Kiri (teks) -->
          <div>
            <h2 class="text-lg font-semibold text-gray-600">Total Customer</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ totalCustomer }}</p>
          </div>

          <!-- Kanan (ikon) -->
          <div class="bg-blue-100 p-4 rounded-full">
            <span class="material-icons text-blue-600 text-4xl">people</span>
          </div>
        </div>
      </div>
      <div class="p-6">
        <!-- Card Statistik -->
        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center justify-between">
          <!-- Kiri (teks) -->
          <div>
            <h2 class="text-lg font-semibold text-gray-600">Total Transaksi</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ totalTransaction }}</p>
          </div>

          <!-- Kanan (ikon) -->
          <div class="bg-blue-100 p-4 rounded-full">
            <span class="material-icons text-blue-600 text-4xl">receipt</span>
          </div>
        </div>
      </div>
      <div v-if="user.role === 'admin'" class="p-6">
        <!-- Card Statistik -->
        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center justify-between">
          <!-- Kiri (teks) -->
          <div>
            <h2 class="text-lg font-semibold text-gray-600">Total Operator</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ totalOperator }}</p>
          </div>

          <!-- Kanan (ikon) -->
          <div class="bg-blue-100 p-4 rounded-full">
            <span class="material-icons text-blue-600 text-4xl">receipt</span>
          </div>
        </div>
      </div>
      <div class="p-6">
        <!-- Card Statistik -->
        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center justify-between">
          <!-- Kiri (teks) -->
          <div>
            <h2 class="text-lg font-semibold text-gray-600">Total Maintenance</h2>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ totalMaintenance }}</p>
          </div>

          <!-- Kanan (ikon) -->
          <div class="bg-blue-100 p-4 rounded-full">
            <span class="material-icons text-blue-600 text-4xl">build</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Table Section -->
<div class="flex items-center justify-between px-6 mt-4">
  <h2 class="text-xl font-semibold text-gray-800">🧾 5 Transaksi Terakhir</h2>
  <Link :href="route('admin.transaction.index')" class="text-blue-600 text-sm hover:underline">
    Lihat semua transaksi →
  </Link>
</div>
    <!-- Table -->
    <div class="overflow-hidden m-6 rounded-lg border border-gray-200 shadow-sm bg-white">
      <table class="min-w-full text-sm text-gray-600">
        <thead class="bg-gray-100 text-gray-700 text-xs uppercase font-semibold">
          <tr>
            <th class="px-4 py-3 text-left">Nama Customer</th>
            <th class="px-4 py-3 text-left">Nama Mobil</th>
            <th class="px-4 py-3 text-left">Mulai Sewa</th>
            <th class="px-4 py-3 text-left">Selesai Sewa</th>
            <th class="px-4 py-3 text-left">Status</th>
            <th class="px-4 py-3 text-left">Total</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="rtx in recentTransactions" :key="rtx.id" class="hover:bg-gray-50 transition">
            <td class="px-4 py-3 font-medium text-gray-800"><button
                class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">{{ rtx.customer.name
                }}</button></td>
            <td class="px-4 py-3"><button
                class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">{{
                  rtx.car.model }}</button></td>
            <td class="px-4 py-3">{{ rtx.start_date }}</td>
            <td class="px-4 py-3">{{ rtx.end_date }}</td>
            <td class="px-4 py-3">
              <span v-if="rtx.status_car === 'rented'"
                class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Disewa</span>
              <span v-else
                class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Dikembalikan</span>
            </td>
            <td class="px-4 py-3">{{ formatRupiah(rtx.total_price) }}</td>
          </tr>
        </tbody>
      </table>
    </div>





  </LayoutAdmin>
</template>

<style>
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");
</style>
