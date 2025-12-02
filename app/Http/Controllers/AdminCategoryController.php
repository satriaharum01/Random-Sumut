<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
//Models
use App\Models\Category;
// Etc.
use DataTables;
use Exception;

class AdminCategoryController extends Controller
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
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->data['title'] = 'Categoreis Management';
        $this->data['sub_title'] = 'List Category ' . env('APP_NAME');

        return view('admin/category/index', $this->data);
    }

    // Query
    public function json()
    {
        $data = Category::withCount('articles')->orderBy('updated_at', 'DESC')->get();


        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Category::findorfail($id);

        return json_encode($data);
    }


    //CRUD
    public function storeJson(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:100']);
        $category = Category::create($validated);

        // Kembalikan JSON untuk update dropdown tanpa reload
        return response()->json($category);
    }

    public function store(Request $request)
    {
        $validator = User::validate($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        User::create($data);

        return redirect()->route('account.user')->with('info', 'User berhasil disimpan.');
    }

    public function update(Request $request, Category $post)
    {
        $validator = User::validate($request->all(), $post->id);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        $post->update($data);

        return redirect()->route('account.category')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect()
                ->route('account.category')
                ->with('delete', 'Category berhasil dihapus.');
        } catch (Exception $e) {
            return back()
                ->with('warning', 'Category gagal dihapus.')
                ->withInput();
        }
    }

    //COUNTERS

    //GRAPH
}
