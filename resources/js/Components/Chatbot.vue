<script setup>
import { ref, nextTick } from "vue";

const isOpen = ref(false);
const message = ref("");
const isTyping = ref(false);

const messages = ref([
  {
    from: "bot",
    text: "Halo 👋 Selamat datang di Rental MobilKu!\nAku CS virtual yang siap bantu kamu 😊",
  },
]);

const quickReplies = [
  "Harga sewa mobil",
  "Syarat sewa",
  "Cara booking",
  "Kontak admin",
];

function toggleChat() {
  isOpen.value = !isOpen.value;
}

function sendMessage(text = null) {
  const userMessage = text || message.value;
  if (!userMessage.trim()) return;

  messages.value.push({
    from: "user",
    text: userMessage,
  });

  message.value = "";
  scrollToBottom();

  // typing indicator
  isTyping.value = true;

  setTimeout(() => {
    isTyping.value = false;
    messages.value.push({
      from: "bot",
      text: getBotReply(userMessage),
    });
    scrollToBottom();
  }, 900);
}

function getBotReply(text) {
  const msg = text.toLowerCase();

  const greeting = ["halo", "hai", "hi", "pagi", "siang", "malam"];
  const harga = ["harga", "biaya", "tarif"];
  const syarat = ["syarat", "jaminan", "persyaratan"];
  const booking = ["booking", "sewa", "pesan"];
  const kontak = ["kontak", "admin", "whatsapp", "wa"];

  if (greeting.some(k => msg.includes(k))) {
    return "Halo 👋 Ada yang bisa aku bantu hari ini?\nKamu bisa tanya soal harga, booking, atau syarat sewa ya 😊";
  }

  if (harga.some(k => msg.includes(k))) {
    return "💰 Harga sewa mobil mulai dari *Rp300.000 / hari*, tergantung jenis mobil yang kamu pilih 🚗";
  }

  if (syarat.some(k => msg.includes(k))) {
    return "📄 Syarat sewa mobil:\n• KTP\n• SIM A\n• Uang jaminan\n• Usia minimal 21 tahun";
  }

  if (booking.some(k => msg.includes(k))) {
    return "📝 Cara booking mobil:\n1️⃣ Pilih mobil\n2️⃣ Tentukan tanggal\n3️⃣ Hubungi admin\n4️⃣ Mobil siap digunakan 😄";
  }

  if (kontak.some(k => msg.includes(k))) {
    return "📞 Admin kami siap membantu:\nWhatsApp: 08xxxxxxxxxx";
  }

  if (msg.length < 3) {
    return "😄 Boleh dijelasin sedikit lagi ya? Aku siap bantu kok.";
  }

  // fallback profesional (INI PENTING)
  return "Maaf aku belum paham 😅\n\nKamu bisa ketik:\n• Harga sewa\n• Cara booking\n• Syarat sewa\n• Kontak admin";
}

function scrollToBottom() {
  nextTick(() => {
    const el = document.getElementById("chat-body");
    if (el) el.scrollTop = el.scrollHeight;
  });
}
</script>

<template>
  <!-- Floating Button -->
  <button
    @click="toggleChat"
    class="fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-xl hover:bg-blue-700 transition z-50"
  >
    💬
  </button>

  <!-- Chat Box -->
  <div
    v-if="isOpen"
    class="fixed bottom-24 right-6 w-80 bg-white rounded-xl shadow-2xl flex flex-col z-50"
  >
    <!-- Header -->
    <div class="bg-blue-600 text-white p-4 rounded-t-xl font-semibold">
      Customer Service
    </div>

    <!-- Body -->
    <div
      id="chat-body"
      class="flex-1 p-4 space-y-2 overflow-y-auto text-sm"
    >
      <div
        v-for="(msg, i) in messages"
        :key="i"
        :class="msg.from === 'user' ? 'text-right' : 'text-left'"
      >
        <span
          :class="msg.from === 'user'
            ? 'bg-blue-600 text-white'
            : 'bg-gray-100 text-gray-700'"
          class="inline-block px-3 py-2 rounded-lg max-w-[85%] whitespace-pre-line"
        >
          {{ msg.text }}
        </span>
      </div>

      <!-- typing indicator -->
      <div v-if="isTyping" class="text-left">
        <span class="bg-gray-100 text-gray-500 px-3 py-2 rounded-lg text-xs">
          sedang mengetik...
        </span>
      </div>
    </div>

    <!-- Quick Reply -->
    <div class="p-2 flex flex-wrap gap-2">
      <button
        v-for="(q, i) in quickReplies"
        :key="i"
        @click="sendMessage(q)"
        class="text-xs border px-2 py-1 rounded hover:bg-gray-100"
      >
        {{ q }}
      </button>
    </div>

    <!-- Input -->
    <div class="p-2 border-t flex gap-2">
      <input
        v-model="message"
        @keyup.enter="sendMessage()"
        type="text"
        placeholder="Tulis pesan..."
        class="flex-1 border rounded px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
      />
      <button
        @click="sendMessage()"
        class="bg-blue-600 text-white px-3 rounded hover:bg-blue-700"
      >
        Kirim
      </button>
    </div>
  </div>
</template>
