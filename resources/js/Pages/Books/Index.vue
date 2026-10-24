
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    books: Object,
    search: {
        type: String,
        default: '',
    },
});

const keyword = ref(props.search ?? '');

function cari() {
    router.get('/books', { search: keyword.value });
}

function hapus(id) {
    if (confirm('Yakin ingin menghapus buku ini?')) {
        router.delete(route('books.destroy', id));
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Data Buku</h1>

            <div
                v-if="$page.props.flash?.success"
                class="mb-4 text-green-700"
            >
                {{ $page.props.flash.success }}
            </div>

            <div
                v-if="$page.props.flash?.error"
                class="mb-4 text-red-700"
            >
                {{ $page.props.flash.error }}
            </div>

            <Link
                href="/books/create"
                class="inline-block mb-4"
            >
                + Tambah Buku
            </Link>

            <div class="mb-4">
                <input
                    v-model="keyword"
                    @keyup.enter="cari"
                    type="text"
                    placeholder="Cari judul atau pengarang..."
                    class="border p-2"
                />
                <button
                    type="button"
                    @click="cari"
                    class="bg-blue-600 text-white px-3 py-2"
                >
                    Cari
                </button>
            </div>

            <table class="w-full border-collapse border">
                <thead>
                    <tr>
                        <th class="border p-2">Kode</th>
                        <th class="border p-2">Judul</th>
                        <th class="border p-2">Pengarang</th>
                        <th class="border p-2">Stok</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="book in books.data"
                        :key="book.id"
                    >
                        <td class="border p-2">
                            {{ book.kode_buku }}
                        </td>
                        <td class="border p-2">
                            {{ book.judul }}
                        </td>
                        <td class="border p-2">
                            {{ book.pengarang }}
                        </td>
                        <td class="border p-2">
                            {{ book.stok }}
                        </td>
                        <td class="border p-2">
                            <Link
                                :href="`/books/${book.id}/edit`"
                                class="text-blue-600 mr-3"
                            >
                                Edit
                            </Link>

                            <button
                                type="button"
                                @click="hapus(book.id)"
                                class="text-red-600"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>

                    <tr v-if="books.data.length === 0">
                        <td colspan="5" class="border p-3 text-center">
                            Data buku tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>