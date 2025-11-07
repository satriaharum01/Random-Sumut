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
        $this->data['sub_title'] = 'List Category '.env('APP_NAME');

        return view('admin/category/index', $this->data);
    }

    public function new()
    {
        $this->data['title'] = 'Artilce Management';
        $this->data['sub_title'] = 'Add New Artilce ';
        $this->data['categories'] = Category::all();

        return view('admin/article/detail', $this->data);
    }

    public function json()
    {
        $data = Category::orderBy('updated_at', 'DESC')->all();


        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
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
        $validator = Article::validate($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        // Upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $data['views'] = 0;

        Article::create($data);

        return redirect()->route('account.article')->with('success', 'Artikel berhasil disimpan.');
    }

    public function update(Request $request, Article $post)
    {
        $validator = Article::validate($request->all(), $post->id);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        // Update image jika ada
        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('account.article')->with('success', 'Artikel berhasil diperbarui.');
    }
    //COUNTERS

    //GRAPH
}
