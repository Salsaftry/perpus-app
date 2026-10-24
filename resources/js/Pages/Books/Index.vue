
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    books: Object,
})
</script>

<template>
    <Head title="Data Buku" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Buku
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="mb-4">
                        <Link
                            :href="route('books.create')"
                            class="px-4 py-2 bg-blue-600 text-white rounded"
                        >
                            Tambah Buku
                        </Link>
                    </div>

                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">No</th>
                                <th class="border p-2">Kode Buku</th>
                                <th class="border p-2">Judul</th>
                                <th class="border p-2">Pengarang</th>
                                <th class="border p-2">Stok</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="(book, index) in books.data"
                                :key="book.id"
                            >
                                <td class="border p-2">{{ index + 1 }}</td>
                                <td class="border p-2">{{ book.kode_buku }}</td>
                                <td class="border p-2">{{ book.judul }}</td>
                                <td class="border p-2">{{ book.pengarang }}</td>
                                <td class="border p-2">{{ book.stok }}</td>
                            </tr>

                            <tr v-if="books.data.length === 0">
                                <td colspan="5" class="text-center p-4">
                                    Belum ada data buku.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
