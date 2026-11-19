<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    nama: '',
    nis_nim: '',
    no_hp: '',
    alamat: '',
    foto: null,
});

function submit() {
    form.post(route('members.store'));
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="container">
            <h1>Tambah Anggota</h1>

            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama Anggota</label>
                    <input v-model="form.nama" type="text">
                    <div v-if="form.errors.nama" class="error">
                        {{ form.errors.nama }}
                    </div>
                </div>

                <div class="form-group">
                    <label>NIS/NIM</label>
                    <input v-model="form.nis_nim" type="text">
                    <div v-if="form.errors.nis_nim" class="error">
                        {{ form.errors.nis_nim }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Nomor HP</label>
                    <input v-model="form.no_hp" type="text">
                    <div v-if="form.errors.no_hp" class="error">
                        {{ form.errors.no_hp }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea v-model="form.alamat"></textarea>
                    <div v-if="form.errors.alamat" class="error">
                        {{ form.errors.alamat }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Foto Anggota</label>
                    <input
                        type="file"
                        accept="image/jpeg,image/png"
                        @input="form.foto = $event.target.files[0]"
                    >
                    <div v-if="form.errors.foto" class="error">
                        {{ form.errors.foto }}
                    </div>
                    <small>Format JPG, JPEG, atau PNG. Maksimal 2 MB.</small>
                </div>

                <button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
                </button>

                <Link href="/members" class="btn-kembali">
                    Kembali
                </Link>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.container {
    padding: 20px;
    max-width: 700px;
}

h1 {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 16px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 6px;
}

input, textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

textarea {
    min-height: 90px;
}

.error {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

small {
    display: block;
    color: #666;
    margin-top: 5px;
}

button, .btn-kembali {
    display: inline-block;
    padding: 9px 14px;
    border: none;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    cursor: pointer;
    margin-right: 5px;
}

button {
    background: #198754;
}

button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-kembali {
    background: #6c757d;
}
</style>
