<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";
import LayoutAdmin from "../../../Components/Layout/LayoutAdmin.vue";
import { reactive, ref, watch } from "vue";
import { route } from "ziggy-js";
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    operators: Object,
    filters: Object
});

let modalCreate = ref(false);

const openModalCreate = () => {
    modalCreate.value = !modalCreate.value;
};

const formStore = useForm({
    name: "",
    email: "",
    password: "",
    age: "",
    gender: "",
    phone: ""
});

const storeoperator = () => {
    formStore.post(route("admin.operator.store"), {
        onSuccess: () => {
            formStore.reset();
            modalCreate.value = false;
        },
    });
};

let modalUpdate = ref(false);

const formUpdate = useForm({
    name: "",
    email: "",
    phone: "",
    age: "",
    gender: "",
});

let userId = ref(null)
let operatorUserId = ref(null);

const openModalUpdate = (operator) => {
    modalUpdate.value = true;

    formUpdate.name = operator.user.name;
    formUpdate.email = operator.user.email;
    formUpdate.plate_number = operator.plate_number;
    formUpdate.phone = operator.phone;
    formUpdate.age = operator.age;
    formUpdate.gender = operator.gender;

    userId.value = operator.user.id
    operatorUserId.value = operator.user_id;

    console.log(modalUpdate.value);

};

const updateoperator = () => {
    formUpdate.put(`/admin/operator/${userId.value}?operator_id=${operatorUserId.value}`, {
        onSuccess: () => {
            formUpdate.reset();
            modalUpdate.value = !modalUpdate.value;
        },
    });
};

const formDelete = useForm({});

let deleteModal = ref(false);
let userIdDelete = ref("");
let operatorNameDelete = ref("");

const openDeleteModal = (operator) => {
    console.log(operator);

    deleteModal.value = !deleteModal.value;
    userIdDelete.value = operator.user.id;
    operatorNameDelete.value = operator.user.name;
};

const deleteoperator = () => {
    formDelete.delete(route("admin.operator.destroy", userIdDelete.value), {
        onSuccess: (deleteModal.value = !deleteModal.value),
    });
};


let search = ref(props.filters?.search ?? "");

// 🔎 search realtime + debounce langsung di watch
let timeout = null;
watch(search, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(route("admin.operator.index"),
            { search: value },
            { preserveState: true, preserveScroll: true, replace: true }
        );
    }, 300); // delay 300ms
});

const resetFilter = () => {
    search.value = ""
}


// logic change password
let modalChangePassword = ref(false);
let formId = ref("")

let passwordForm = useForm({
    password: "",
});

const openModalChangePassword = (operator) => {
    formId.value = operator.user.id
    passwordForm.password = "";
    modalChangePassword.value = true;
};

const changePassword = () => {
    passwordForm.post(route("admin.operator.change.password", formId.value), {
        onSuccess: () => {
            modalChangePassword.value = false;
        },
    });
};

const showPassword = ref(false);
</script>

<template>
    <LayoutAdmin>
        <Head title="Operator" />
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <span class="material-icons text-blue-600">manage_accounts</span>
                Daftar operator
            </h2>

            <div class="flex gap-2">
                <!-- Search -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-2 flex items-center text-gray-400">
                        <span class="material-icons text-sm">search</span>
                    </span>
                    <input type="text" v-model="search" placeholder="Cari operator..."
                        class="border rounded-lg pl-8 pr-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </div>

                <button @click="resetFilter"
                    class="flex items-center gap-1 px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                    <span class="material-icons text-base">restart_alt</span>
                    Reset
                </button>

                <!-- Tambah operator -->
                <button @click="openModalCreate"
                    class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                    <span class="material-icons text-sm">person_add</span>
                    Tambah operator
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm bg-white">
            <table class="min-w-full text-sm text-gray-600">
                <thead class="bg-gray-100 text-gray-700 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Umur</th>
                        <th class="px-4 py-3 text-left">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left">No Telp</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="operator in operators.data" :key="operator.id" class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ operator.user.name }}</td>
                        <td class="px-4 py-3">{{ operator.user.email }}</td>
                        <td class="px-4 py-3">{{ operator.age }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold" :class="operator.gender === 'L'
                                ? 'bg-blue-100 text-blue-700'
                                : 'bg-pink-100 text-pink-700'">
                                {{ operator.gender === 'L' ? "Laki-laki" : "Perempuan" }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ operator.phone }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="inline-flex space-x-2">
                                <button @click="openModalChangePassword(operator)"
                                    class="p-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 flex items-center justify-center"
                                    title="Ubah Password">
                                    <span class="material-icons text-sm">lock</span>
                                </button>

                                <button @click="openModalUpdate(operator)"
                                    class="p-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 flex items-center justify-center"
                                    title="Edit Mobil">
                                    <span class="material-icons text-sm">edit</span>
                                </button>
                                <button @click="openDeleteModal(operator)"
                                    class="p-2 rounded-lg bg-red-500 text-white hover:bg-red-600 flex items-center justify-center"
                                    title="Hapus Mobil">
                                    <span class="material-icons text-sm">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-end items-center space-x-1">
            <!-- Prev -->
            <button @click="
                operators.prev_page_url &&
                router.get(
                    operators.prev_page_url,
                    {},
                    { preserveState: true, preserveScroll: true }
                )
                " class="px-3 py-1.5 rounded-lg border text-sm transition-all duration-200" :class="operators.prev_page_url
                    ? 'bg-white text-gray-600 border-gray-300 hover:bg-blue-50 hover:text-blue-600'
                    : 'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed'
                    " :disabled="!operators.prev_page_url">
                «
            </button>

            <!-- Numbered Pages -->
            <button v-for="link in operators.links.filter((l) => !isNaN(l.label))" :key="link.url ?? link.label" @click="
                router.get(
                    link.url,
                    {},
                    { preserveState: true, preserveScroll: true }
                )
                " v-html="link.label"
                class="px-3 py-1.5 rounded-lg border text-sm font-medium transition-all duration-200" :class="[
                    link.active
                        ? 'bg-blue-600 text-white border-blue-600 shadow-sm'
                        : 'bg-white text-gray-600 border-gray-300 hover:bg-blue-50 hover:text-blue-600',
                ]" />

            <!-- Next -->
            <button @click="
                operators.next_page_url &&
                router.get(
                    operators.next_page_url,
                    {},
                    { preserveState: true, preserveScroll: true }
                )
                " class="px-3 py-1.5 rounded-lg border text-sm transition-all duration-200" :class="operators.next_page_url
                    ? 'bg-white text-gray-600 border-gray-300 hover:bg-blue-50 hover:text-blue-600'
                    : 'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed'
                    " :disabled="!operators.next_page_url">
                »
            </button>
        </div>


        <!-- modal create -->
        <div v-if="modalCreate"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50"
            @click.self="modalCreate = !modalCreate">
            <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl w-full max-w-2xl p-6 relative">
                <!-- Tombol Close -->
                <button @click="modalCreate = !modalCreate"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                    ✕
                </button>

                <h2 class="text-xl font-bold text-gray-800 mb-6">
                    Tambah operator Baru
                </h2>

                <form @submit.prevent="storeoperator" class="space-y-4">
                    <!-- Grid formStore -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <span v-if="formStore.errors.name" class="text-red-700 italic">{{ formStore.errors.name
                            }}</span>
                            <input type="text" v-model="formStore.name"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <span v-if="formStore.errors.email" class="text-red-700 italic">{{ formStore.errors.email
                            }}</span>
                            <input type="email" v-model="formStore.email"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200" />
                        </div>


                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Passwords</label>
                            <span v-if="formStore.errors.password" class="text-red-700 italic">{{
                                formStore.errors.password }}</span>
                            <input type="password" v-model="formStore.password"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Umur</label>
                            <span v-if="formStore.errors.age" class="text-red-700 italic">{{ formStore.errors.age
                            }}</span>
                            <input type="number" v-model="formStore.age"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200" />
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                            <span v-if="formStore.errors.gender" class="text-red-700 italic">{{ formStore.errors.gender
                            }}</span>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" v-model="formStore.gender" value="L" />
                                    <span>Laki-laki</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" v-model="formStore.gender" value="P" />
                                    <span>Perempuan</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No Telp</label>
                            <span v-if="formStore.errors.phone" class="text-red-700 italic">{{ formStore.errors.phone
                            }}</span>
                            <input type="number" v-model="formStore.phone"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200" />
                        </div>

                    </div>






                    <!-- Tombol -->
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- modal update -->
        <div v-if="modalUpdate"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50"
            @click.self="modalUpdate = !modalUpdate">
            <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl w-full max-w-2xl p-6 relative">
                <!-- Tombol Close -->
                <button @click="modalUpdate = !modalUpdate"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                    ✕
                </button>

                <h2 class="text-xl font-bold text-gray-800 mb-6">
                    Edit operator
                </h2>

                <form @submit.prevent="updateoperator" class="space-y-4">
                    <!-- Grid formUpdate -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <span v-if="formUpdate.errors.name" class="text-red-700 italic">{{ formUpdate.errors.name
                            }}</span>
                            <input type="text" v-model="formUpdate.name"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <span v-if="formUpdate.errors.email" class="text-red-700 italic">{{ formUpdate.errors.email
                            }}</span>
                            <input type="email" v-model="formUpdate.email"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telp</label>
                            <span v-if="formUpdate.errors.phone" class="text-red-700 italic">{{ formUpdate.errors.phone
                            }}</span>
                            <input type="text" v-model="formUpdate.phone"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Umur</label>
                            <span v-if="formUpdate.errors.age" class="text-red-700 italic">{{ formUpdate.errors.age
                            }}</span>
                            <input type="text" v-model="formUpdate.age"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200" />
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <span v-if="formUpdate.errors.gender" class="text-red-700 italic">{{ formUpdate.errors.gender
                        }}</span>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" v-model="formUpdate.gender" value="L" />
                                <span>Laki-laki</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" v-model="formUpdate.gender" value="P" />
                                <span>Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Delete -->
        <div v-if="deleteModal"
            class="fixed inset-0 flex items-start justify-center pt-20 z-50 bg-black/30 backdrop-blur-sm">
            <!-- Modal Box -->
            <div class="bg-white/80 backdrop-blur-md rounded-xl shadow-lg w-full max-w-md p-6 relative">
                <!-- Tombol X -->
                <button @click="deleteModal = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                    ✕
                </button>

                <!-- Judul -->
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Konfirmasi Hapus
                </h2>

                <!-- Isi -->
                <p class="text-gray-600 mb-6">
                    Yakin ingin menghapus operator dengan nama:
                    <span class="font-bold text-red-500">{{
                        operatorNameDelete
                    }}</span>
                    ?
                </p>

                <!-- Tombol aksi -->
                <div class="flex justify-end space-x-3">
                    <button @click="deleteModal = false"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Batal
                    </button>
                    <button @click="deleteoperator" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus
                    </button>
                </div>
            </div>
        </div>



        <!-- modal change password -->
        <div v-if="modalChangePassword"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
            @click.self="modalChangePassword = false">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 relative">
                <button @click="modalChangePassword = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✖</button>

                <h2 class="text-xl font-bold text-gray-800 mb-4">Ubah Password Operator</h2>

                <form @submit.prevent="changePassword">
                    <div class="space-y-3">
                        <label class="text-sm font-medium text-gray-700 mb-1 block">Password Baru</label>
                        <span v-if="passwordForm.errors.password" class="text-red-700 italic">
                            {{ passwordForm.errors.password }}
                        </span>

                        <div class="relative">
                            <!-- Input Password -->
                            <input :type="showPassword ? 'text' : 'password'" v-model="passwordForm.password"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 text-sm focus:ring focus:ring-blue-200"
                                required />

                            <!-- Toggle Icon -->
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute top-1/2 -translate-y-1/2 right-3 text-gray-500 hover:text-gray-700 focus:outline-none"
                                tabindex="-1">
                                <EyeIcon v-if="!showPassword" class="h-5 w-5" />
                                <EyeSlashIcon v-else class="h-5 w-5" />
                            </button>
                        </div>
                    </div>


                    <div class="flex justify-end gap-3 pt-5">
                        <button type="button" @click="modalChangePassword = false"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </LayoutAdmin>
</template>
