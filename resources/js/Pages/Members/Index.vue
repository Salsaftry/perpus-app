<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    members: Object,
    search: {
        type: String,
        default: '',
    },
});

const keyword = ref(props.search ?? '');

function cari() {
    router.get('/members', {
        search: keyword.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
}

function hapus(id) {
    if (confirm('Yakin ingin menghapus anggota ini?')) {
        router.delete(route('members.destroy', id));
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="container">
            <h1>Data Anggota</h1>

            <div v-if="$page.props.flash?.success" class="alert-success">
                {{ $page.props.flash.success }}
            </div>

            <div v-if="$page.props.flash?.error" class="alert-error">
                {{ $page.props.flash.error }}
            </div>

            <div class="toolbar">
                <Link href="/members/create" class="btn-tambah">
                    + Tambah Anggota
                </Link>
            </div>

            <div class="search-box">
                <input
                    v-model="keyword"
                    @keyup.enter="cari"
                    type="text"
                    placeholder="Cari nama, NIS/NIM, atau nomor HP..."
                >

                <button type="button" @click="cari">
                    Cari
                </button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>NIS/NIM</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="(member, index) in members.data"
                        :key="member.id"
                    >
                        <td>
                            {{ (members.current_page - 1) * members.per_page + index + 1 }}
                        </td>

                        <td>
                            <img
                                v-if="member.foto"
                                :src="`/storage/${member.foto}`"
                                alt="Foto anggota"
                                class="foto-anggota"
                            >
                            <span v-else>Belum ada foto</span>
                        </td>

                        <td>{{ member.nama }}</td>
                        <td>{{ member.nis_nim }}</td>
                        <td>{{ member.no_hp || '-' }}</td>
                        <td>{{ member.alamat || '-' }}</td>

                        <td>
                            <Link
                                :href="`/members/${member.id}/edit`"
                                class="btn-edit"
                            >
                                Edit
                            </Link>

                            <button
                                type="button"
                                @click="hapus(member.id)"
                                class="btn-hapus"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>

                    <tr v-if="members.data.length === 0">
                        <td colspan="7">
                            Data anggota tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="pagination">
                <template
                    v-for="(link, index) in members.links"
                    :key="index"
                >
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        v-html="link.label"
                        :class="{ active: link.active }"
                    />

                    <span v-else v-html="link.label" />
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

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background: #f2f2f2;
}

.foto-anggota {
    width: 65px;
    height: 65px;
    object-fit: cover;
    border-radius: 6px;
}

.btn-edit, .btn-hapus {
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

.pagination a, .pagination span {
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
