<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\ProcessPatientsImport;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.imports.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $path = $request->file('file')->store('imports');

        ProcessPatientsImport::dispatch($path);

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Archivo recibido. Los pacientes se están importando en segundo plano.'
        ]);

        return redirect()->route('admin.imports.index');
    }
}
