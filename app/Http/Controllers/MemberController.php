<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    // Menampilkan daftar anggota
    public function index(Request $request)
    {
        $members = Member::when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis_nim', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return inertia('Members/Index', [
            'members' => $members,
            'search' => $request->search,
        ]);
    }

    // Menampilkan formulir tambah anggota
    public function create()
    {
        return inertia('Members/Create');
    }

    // Menyimpan anggota baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'nis_nim' => 'required|unique:members,nis_nim',
            'no_hp' => 'nullable|max:20',
            'alamat' => 'nullable|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')
                ->store('members', 'public');
        }

        Member::create($validated);

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    // Detail anggota
    public function show(Member $member)
    {
        return redirect()->route('members.index');
    }

    // Menampilkan formulir edit anggota
    public function edit(Member $member)
    {
        return inertia('Members/Edit', [
            'member' => $member,
        ]);
    }

    // Memperbarui data anggota
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'nis_nim' => 'required|unique:members,nis_nim,' . $member->id,
            'no_hp' => 'nullable|max:20',
            'alamat' => 'nullable|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika ada foto baru, simpan foto tersebut
        if ($request->hasFile('foto')) {
            $fotoBaru = $request->file('foto')
                ->store('members', 'public');

            // Hapus foto lama setelah foto baru berhasil disimpan
            if ($member->foto) {
                Storage::disk('public')->delete($member->foto);
            }

            $validated['foto'] = $fotoBaru;
        } else {
            // Pertahankan foto lama jika tidak ada foto baru
            unset($validated['foto']);
        }

        $member->update($validated);

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    // Menghapus anggota
    public function destroy(Member $member)
    {
        if ($member->foto) {
            Storage::disk('public')->delete($member->foto);
        }

        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }
}
