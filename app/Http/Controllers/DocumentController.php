<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;




class DocumentController extends Controller
{

    public function index(Request $request)
    {
        $query = Document::query();

        if ($search = $request->get('search')) {
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }

        $documents = $query->paginate(20);
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function generateQR($id)
    {
        $document = Document::findOrFail($id);
        $qrCode = QrCode::format('png')->size(300)->generate(route('documents.view', $document->id));
        $document->qr_code = base64_encode($qrCode);
        $document->save();

        return redirect()->route('documents.index')->with('success', 'QR Code generated successfully.');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'file' => 'required|file|mimes:pdf'
        ]);

        $path = $request->file('file')->store('public/documents');

        $document = new Document();
        $document->title = $validatedData['title'];
        $document->description = $validatedData['description'];
        $document->file_path = $path;
        $document->user_id = Auth::id();
        $document->save();

        return redirect()->route('documents.index')->with('message', 'Document uploaded successfully.');
    }

    public function show(Document $document)
    {
        $filePath = $document->file_path;

        $fileSize = Storage::size($filePath);

        $fileSizeFormatted = $this->formatBytes($fileSize);
        return view('documents.show', compact('document', 'fileSizeFormatted'));
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'file' => 'nullable|file'
        ]);

        if ($request->hasFile('file')) {
            Storage::delete($document->file_path);
            $path = $request->file('file')->store('public/documents');
            $document->file_path = $path;
        }

        $document->title = $validatedData['title'];
        $document->description = $validatedData['description'];
        $document->save();

        return redirect()->route('documents.index')->with('message', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        Storage::delete($document->file_path);
        $document->delete();
        return redirect()->route('documents.index')->with('message', 'Document deleted successfully.');
    }



    public function viewDocument($qr_code)
    {
        $document = Document::where('qr_code', $qr_code)->firstOrFail();
        return view('documents.view', compact('document'));
    }
    public function openDocument(Document $document)
    {
        $filePath = $document->file_path;

        $fileSize = Storage::size($filePath);

        $fileSizeFormatted = $this->formatBytes($fileSize);

        return view('documents.open', compact('document', 'fileSizeFormatted'));
    }

    private function formatBytes($bytes, $decimals = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        return number_format($bytes / pow(1024, $power), $decimals) . ' ' . $units[$power];
    }
}
// app/Http/Controllers/DocumentController.php
