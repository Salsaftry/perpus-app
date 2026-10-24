
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    kode_buku: '',
    judul: '',
    pengarang: '',
    stok: 0,
})

const submit = () => {
    form.post(route('books.store'))
}
</script>

<template>
    <Head title="Tambah Buku" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Buku
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block mb-1">Kode Buku</label>
                            <input v-model="form.kode_buku" type="text"
                                class="w-full border-gray-300 rounded-md" />
                            <div v-if="form.errors.kode_buku" class="text-red-600">
                                {{ form.errors.kode_buku }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">Judul Buku</label>
                            <input v-model="form.judul" type="text"
                                class="w-full border-gray-300 rounded-md" />
                            <div v-if="form.errors.judul" class="text-red-600">
                                {{ form.errors.judul }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">Pengarang</label>
                            <input v-model="form.pengarang" type="text"
                                class="w-full border-gray-300 rounded-md" />
                            <div v-if="form.errors.pengarang" class="text-red-600">
                                {{ form.errors.pengarang }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">Stok</label>
                            <input v-model.number="form.stok" type="number" min="0"
                                class="w-full border-gray-300 rounded-md" />
                            <div v-if="form.errors.stok" class="text-red-600">
                                {{ form.errors.stok }}
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                :disabled="form.processing"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md">
                                Simpan
                            </button>

                            <Link :href="route('books.index')"
                                class="px-4 py-2 bg-gray-200 rounded-md">
                                Kembali
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
