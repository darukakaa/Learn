<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DataSiswaController extends Controller
{
    /**
     * Display the data siswa page.
     */
    public function index()
    {
        // Fetch only users with the role '2' and order by the latest created_at
        $users = User::where('role', 2)
            ->orderBy('created_at', 'desc') // Ordering by created_at in descending order
            ->get();

        return view('data-siswa', compact('users'));
    }
    public function updateRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'new_role' => 'required|in:0,1,2',
        ]);

        $user = User::find($request->user_id);
        $user->role = $request->new_role;
        $user->save();

        return redirect()->back()->with('success', 'Role berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success_delete', 'User berhasil dihapus.');
    }
}
