<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $walas = Walas::with(['guru', 'siswa'])->get();
        return view('walas.index', compact('walas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all gurus who are not yet walas
        $gurus = Guru::whereNotIn('idguru', function($query) {
            $query->select('idguru')->from('datawalas');
        })->get();

        return view('walas.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idguru' => 'required|exists:dataguru,idguru|unique:datawalas,idguru',
            'jenjang' => 'required|in:X,XI,XII',
            'namakelas' => 'required|string|max:10',
            'tahunajaran' => 'required|string|max:9',
        ]);

        try {
            Walas::create($request->all());
            return redirect()->route('walas.index')
                ->with('success', 'Wali kelas berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Walas $wala)
    {
        // Eager load relationships
        $walas = $wala->load(['guru', 'siswa']);
        
        // Get students who are not in any class
        $availableSiswa = Siswa::whereNotIn('idsiswa', function($query) {
            $query->select('idsiswa')->from('datakelas');
        })->get();

        return view('walas.show', compact('walas', 'availableSiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Walas $wala)
    {
        $walas = $wala;
        return view('walas.edit', compact('walas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Walas $wala)
    {
        $request->validate([
            'jenjang' => 'required|in:X,XI,XII',
            'namakelas' => 'required|string|max:10',
            'tahunajaran' => 'required|string|max:9',
        ]);

        try {
            $wala->update($request->only(['jenjang', 'namakelas', 'tahunajaran']));
            return redirect()->route('walas.index')
                ->with('success', 'Data wali kelas berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Walas $wala)
    {
        try {
            // Start transaction to ensure data consistency
            DB::beginTransaction();
            
            // First, delete related kelas records
            $wala->kelas()->delete();
            
            // Then delete the walas
            $wala->delete();
            
            DB::commit();
            
            return redirect()->route('walas.index')
                ->with('success', 'Wali kelas berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
