<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profile_index()
    {
        return view(auth()->user()->role == "student" ? 'user.profile' : 'admin.profile');
    }
    public function profile(User $user, Request $request)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,

            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
        return back()->with('message', 'successfully Updated');
    }
    public function document(Request $request)
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
        return view('user.document', compact('documents'));
    }
    public function show(Document $document)
    {
        $filePath = $document->file_path;

        // Get the file size in bytes
        $fileSize = Storage::size($filePath);

        // Convert bytes to a human-readable format (optional)
        $fileSizeFormatted = $this->formatBytes($fileSize);
        return view('user.document_show', compact('document', 'fileSizeFormatted'));
    }

    private function formatBytes($bytes, $decimals = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        return number_format($bytes / pow(1024, $power), $decimals) . ' ' . $units[$power];
    }
}
