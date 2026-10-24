<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    book: Object,
});

const form = useForm({
    kode_buku: props.book.kode_buku,
    judul: props.book.judul,
    pengarang: props.book.pengarang,
    penerbit: props.book.penerbit ?? '',
    tahun: props.book.tahun ?? '',
    stok: props.book.stok,
});

function submit() {
    form.put(route('books.update', props.book.id));
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Edit Buku</h1>

            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label>Kode Buku</label>
                    <input
                        v-model="form.kode_buku"
                        type="text"
                        class="block border p-2 w-full"
                    />
                    <div v-if="form.errors.kode_buku">
                        {{ form.errors.kode_buku }}
                    </div>
                </div>

                <div class="mb-3">
                    <label>Judul</label>
                    <input
                        v-model="form.judul"
                        type="text"
                        class="block border p-2 w-full"
                    />
                    <div v-if="form.errors.judul">
                        {{ form.errors.judul }}
                    </div>
                </div>

                <div class="mb-3">
                    <label>Pengarang</label>
                    <input
                        v-model="form.pengarang"
                        type="text"
                        class="block border p-2 w-full"
                    />
                    <div v-if="form.errors.pengarang">
                        {{ form.errors.pengarang }}
                    </div>
                </div>

                <div class="mb-3">
                    <label>Penerbit</label>
                    <input
                        v-model="form.penerbit"
                        type="text"
                        class="block border p-2 w-full"
                    />
                </div>

                <div class="mb-3">
                    <label>Tahun</label>
                    <input
                        v-model="form.tahun"
                        type="text"
                        class="block border p-2 w-full"
                    />
                    <div v-if="form.errors.tahun">
                        {{ form.errors.tahun }}
                    </div>
                </div>

                <div class="mb-3">
                    <label>Stok</label>
                    <input
                        v-model="form.stok"
                        type="number"
                        min="0"
                        class="block border p-2 w-full"
                    />
                    <div v-if="form.errors.stok">
                        {{ form.errors.stok }}
                    </div>
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-blue-600 text-white px-4 py-2 rounded"
                >
                    {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>