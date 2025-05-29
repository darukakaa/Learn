<?php

namespace App\Http\Controllers;

use App\Models\TugasFile;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class TugasController extends Controller
{
    public function index()
    {
        // Retrieve all tasks ordered by 'tanggal_dibuat' in descending order
        $tugas = Tugas::orderBy('created_at', 'desc')->get();


        // If you want to check for a specific task, you can set it here
        $task = null; // or retrieve a specific task if needed

        // Pass both variables to the view
        return view('tugas.index', compact('tugas', 'task'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tugas' => 'required|string|max:255',
            'tanggal_dibuat' => 'required|date',
        ]);

        Tugas::create([
            'nama_tugas' => $request->nama_tugas,
            'tanggal_dibuat' => $request->tanggal_dibuat,
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan.');
    }
    public function show($id)
    {
        $tugas = Tugas::all();
        $task = Tugas::with('uploadedFiles.user')->findOrFail($id);
        return view('tugas.show', compact('task'));
    }
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,ppt,pptx|max:2048' // Set acceptable file types and size
        ]);

        // Store file and get the path
        $filePath = $request->file('file')->store('tugas_files');

        // Save the file information in the database
        TugasFile::create([
            'tugas_id' => $id,
            'user_id' => auth()->id(),
            'file_path' => $filePath,
            'is_validated' => false, // Initially set to unvalidated
        ]);

        // Set session variable to indicate file upload
        session()->flash('uploaded', true);

        return redirect()->back()->with('success', 'File berhasil anda upload');
    }


    public function validate($id)
    {
        $file = TugasFile::findOrFail($id);
        $file->is_validated = true; // Validate the file
        $file->save();

        return response()->json([
            'is_validated' => true,
            'message' => 'File berhasil divalidasi.'
        ]);
    }

    public function unvalidate($id)
    {
        $file = TugasFile::findOrFail($id);
        $file->is_validated = false; // Unvalidate the file
        $file->save();

        return response()->json([
            'is_validated' => false,
            'message' => 'File berhasil diunvalidasi.'
        ]);
    }

    public function destroy($id)
    {
        $task = Tugas::findOrFail($id);
        $task->delete();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
