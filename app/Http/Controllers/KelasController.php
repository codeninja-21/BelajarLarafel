<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Walas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $idwalas = $request->query('idwalas');
        
        // Validate if the walas exists
        $walas = Walas::findOrFail($idwalas);
        
        // Get students who are not in any class
        $availableSiswa = Siswa::whereNotIn('idsiswa', function($query) {
            $query->select('idsiswa')->from('datakelas');
        })->get();

        return view('kelas.create', compact('idwalas', 'availableSiswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idwalas' => 'required|exists:datawalas,idwalas',
            'idsiswa' => 'required|exists:datasiswa,idsiswa|unique:datakelas,idsiswa',
        ]);

        try {
            // Check if the student is already in a class
            $existingKelas = Kelas::where('idsiswa', $request->idsiswa)->first();
            if ($existingKelas) {
                return redirect()->back()
                    ->with('error', 'Siswa sudah terdaftar di kelas lain')
                    ->withInput();
            }

            Kelas::create($request->all());
            
            return redirect()->route('walas.show', $request->idwalas)
                ->with('success', 'Siswa berhasil ditambahkan ke kelas');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $kelas = Kelas::findOrFail($id);
            $idwalas = $kelas->idwalas;
            
            $kelas->delete();
            
            return redirect()->route('walas.show', $idwalas)
                ->with('success', 'Siswa berhasil dikeluarkan dari kelas');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
