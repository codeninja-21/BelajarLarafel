<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreKelasRequest;
use App\Services\KelasService;

class KelasController extends Controller
{
    protected $service;

    public function __construct(KelasService $service)
    {
        $this->service = $service;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $idwalas = $request->query('idwalas');
        
        // Validate if the walas exists
        $walas = $this->service->getWalasById($idwalas);
        
        // Get students who are not in any class
        $availableSiswa = $this->service->getAvailableSiswa();

        return view('kelas.create', compact('idwalas', 'availableSiswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKelasRequest $request)
    {
        try {
            $this->service->createKelas($request->validated());
            
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
            $idwalas = $this->service->deleteKelas($id);
            
            return redirect()->route('walas.show', $idwalas)
                ->with('success', 'Siswa berhasil dikeluarkan dari kelas');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
