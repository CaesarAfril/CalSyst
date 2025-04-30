<?php

namespace App\Http\Controllers;

use App\Models\References;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RefController extends Controller
{
    public function index()
    {
        $document = References::all();
        return view('references.reference', [
            'documents' => $document
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'document_file' => 'required|file'
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = $file->getClientOriginalName();
            $folder = "document/references";
            $path = $file->storeAs($folder, $filename, 'public');

            References::create([
                'document_name' => $request->document_name,
                'filename' => $filename,
                'path' => $path
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil upload referensi');
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'edit_document_name' => 'required|string|max:255',
                'edit_document_file' => 'required|file'
            ]);

            $update = References::findOrFail($id);

            if ($request->hasFile('edit_document_file')) {
                $file = $request->file('edit_document_file');
                $filename = $file->getClientOriginalName();
                $folder = "document/references";
                $path = $file->storeAs($folder, $filename, 'public');

                $update->update([
                    'document_name' => $request->edit_document_name,
                    'filename' => $filename,
                    'path' => $path
                ]);
            }

            return redirect()->back()->with('success', 'File berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui file: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $reference = References::findOrFail($id);

        if ($reference->path && Storage::disk('public')->exists($reference->path)) {
            Storage::disk('public')->delete($reference->path);
        }

        $reference->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}