<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Http\Requests\StoreWalasRequest;
use App\Http\Requests\UpdateWalasRequest;
use App\Services\WalasService;

class WalasController extends Controller
{
    protected $service;

    public function __construct(WalasService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $walas = $this->service->getAllWalas();
        return view('walas.index', compact('walas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gurus = $this->service->getAvailableGurus();
        return view('walas.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWalasRequest $request)
    {
        try {
            $this->service->createWalas($request->validated());
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
        $availableSiswa = $this->service->getAvailableSiswa();

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
    public function update(UpdateWalasRequest $request, Walas $wala)
    {
        try {
            $this->service->updateWalas($wala, $request->validated());
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
            $this->service->deleteWalas($wala);
            return redirect()->route('walas.index')
                ->with('success', 'Wali kelas berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
