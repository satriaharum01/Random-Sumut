<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
//Models
use App\Models\User;
// Etc.
use DataTables;
use Exception;
use Hash;

class AdminUsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->data['title'] = 'Users Management';
        $this->data['sub_title'] = 'List User ' . env('APP_NAME');

        return view('admin/user/index', $this->data);
    }

    public function form(?User $user)
    {
        $this->data['title'] = 'User Management';
        $this->data['sub_title'] = $user ? 'Edit User' : 'Add New User';
        $this->data['user'] = $user;
        
        return view('admin.user.detail', $this->data);
    }

    // Query
    public function json()
    {
        $data = User::orderBy('name', 'ASC')->get();

        foreach ($data as $row) {
            $path = public_path('avatar/' . $row->avatar);

            $row->avatar = (!empty($row->avatar) && file_exists($path))
                ? asset('avatar/' . $row->avatar)
                : asset('avatar/OawWpWlmNieu.jpg');
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = User::findorfail($id);

        return json_encode($data);
    }

    //CRUD
    public function store(Request $request)
    {
        $validator = User::validate($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'email', 'level','role']);

        // UPLOAD AVATAR
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')
                ->store('', 'avatar_upload');
        }

        // PASSWORD
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // INSERT DATA
        User::create($data);

        return redirect()
            ->route('account.user')
            ->with('success', 'User berhasil disimpan.');
    }

    public function update(Request $request, User $user)
    {
        // VALIDATION (ignore email milik sendiri)
        $validator = User::validate($request->all(), $user->id);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'email', 'level','role']);

        // UPDATE AVATAR
        if ($request->hasFile('avatar')) {

            // Hapus avatar lama (jika ada)
            if ($user->avatar && Storage::disk('avatar_upload')->exists($user->avatar)) {
                Storage::disk('avatar_upload')->delete($user->avatar);
            }

            // Upload avatar baru
            $data['avatar'] = $request->file('avatar')
                ->store('', 'avatar_upload');
        }

        // UPDATE PASSWORD (jika diisi)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // UPDATE DATA
        $user->update($data);

        return redirect()
            ->route('account.user')
            ->with('success', 'User berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Hapus avatar (jika ada & bukan avatar default)
            if ($user->avatar && Storage::disk('avatar_upload')->exists($user->avatar)) {
                Storage::disk('avatar_upload')->delete($user->avatar);
            }

            // Hapus user
            $user->delete();

            return redirect()
                ->route('account.user')
                ->with('delete', 'User berhasil dihapus.');
        } catch (\Exception $e) {

            // (opsional) log error
            // Log::error($e->getMessage());

            return back()
                ->with('warning', 'User gagal dihapus.')
                ->withInput();
        }
    }
    //COUNTERS

    //GRAPH
}
