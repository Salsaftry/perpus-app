<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

// Menerima data buku, kata kunci pencarian, dan pesan dari Laravel
const props = defineProps({
    books: Object,
    search: {
        type: String,
        default: '',
    },
});

// Menyimpan kata kunci pencarian
const keyword = ref(props.search ?? '');

// Fungsi pencarian buku
function cari() {
    router.get('/books', {
        search: keyword.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
}

// Fungsi menghapus buku dengan konfirmasi
function hapus(id) {
    if (confirm('Yakin ingin menghapus buku ini?')) {
        router.delete(route('books.destroy', id));
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="container">
            <h1>Data Buku</h1>

            <!-- Pesan sukses -->
            <div
                v-if="$page.props.flash?.success"
                class="alert-success"
            >
                {{ $page.props.flash.success }}
            </div>

            <!-- Pesan error -->
            <div
                v-if="$page.props.flash?.error"
                class="alert-error"
            >
                {{ $page.props.flash.error }}
            </div>

            <!-- Tombol tambah buku -->
            <div class="toolbar">
                <Link href="/books/create" class="btn-tambah">
                    + Tambah Buku
                </Link>
            </div>

            <!-- Form pencarian -->
            <div class="search-box">
                <input
                    v-model="keyword"
                    @keyup.enter="cari"
                    type="text"
                    placeholder="Cari kode, judul, atau pengarang..."
                >

                <button type="button" @click="cari">
                    Cari
                </button>
            </div>

            <!-- Tabel daftar buku -->
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Buku</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="(book, index) in books.data"
                        :key="book.id"
                    >
                        <td>{{ (books.current_page - 1) * books.per_page + index + 1 }}</td>
                        <td>{{ book.kode_buku }}</td>
                        <td>{{ book.judul }}</td>
                        <td>{{ book.pengarang }}</td>
                        <td>{{ book.penerbit }}</td>
                        <td>{{ book.tahun }}</td>
                        <td>{{ book.stok }}</td>

                        <td>
                            <!-- Tombol edit -->
                            <Link
                                :href="`/books/${book.id}/edit`"
                                class="btn-edit"
                            >
                                Edit
                            </Link>

                            <!-- Tombol hapus -->
                            <button
                                type="button"
                                @click="hapus(book.id)"
                                class="btn-hapus"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>

                    <!-- Jika tidak ada data -->
                    <tr v-if="books.data.length === 0">
                        <td colspan="8">
                            Data buku tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Navigasi halaman -->
            <div class="pagination">
                <template
                    v-for="(link, index) in books.links"
                    :key="index"
                >
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        v-html="link.label"
                        :class="{ active: link.active }"
                    />

                    <span
                        v-else
                        v-html="link.label"
                    />
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.container {
    padding: 20px;
}

h1 {
    margin-bottom: 20px;
    font-size: 26px;
    font-weight: bold;
}

.toolbar {
    margin-bottom: 15px;
}

.btn-tambah {
    display: inline-block;
    padding: 9px 14px;
    background: #198754;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.search-box {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
}

.search-box input {
    padding: 9px;
    width: 300px;
    max-width: 100%;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.search-box button {
    padding: 9px 15px;
    background: #0d6efd;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.alert-success {
    padding: 12px;
    margin-bottom: 15px;
    color: #155724;
    background: #d4edda;
    border-radius: 5px;
}

.alert-error {
    padding: 12px;
    margin-bottom: 15px;
    color: #721c24;
    background: #f8d7da;
    border-radius: 5px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th,
td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background: #f2f2f2;
}

.btn-edit,
.btn-hapus {
    display: inline-block;
    padding: 6px 10px;
    margin: 2px;
    border: none;
    border-radius: 4px;
    color: white;
    text-decoration: none;
    cursor: pointer;
}

.btn-edit {
    background: #0d6efd;
}

.btn-hapus {
    background: #dc3545;
}

.pagination {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-top: 20px;
}

.pagination a,
.pagination span {
    padding: 7px 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
}

.pagination .active {
    background: #0d6efd;
    color: white;
}
</style>