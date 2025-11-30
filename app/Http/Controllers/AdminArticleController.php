<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
//Models
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
// Etc.
use DataTables;
use Exception;

class AdminArticleController extends Controller
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
        $this->data['title'] = 'Article Management';
        $this->data['sub_title'] = 'List Article '.env('APP_NAME');

        return view('admin/article/index', $this->data);
    }

    public function new()
    {
        $this->data['title'] = 'Artilce Management';
        $this->data['sub_title'] = 'Add New Artilce ';
        $this->data['categories'] = Category::all();
        $this->data['tags'] = Tag::all();
        $this->data['authors'] = User::all();

        return view('admin/article/detail', $this->data);
    }

    public function json()
    {
        $data = Article::query()->with(['author:id,name'])->orderBy('updated_at', 'DESC');

        if (Auth::user()->role !== 'Admin') {
            $data->where('author_id', Auth::id());
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD
    public function store(Request $request)
    {
        $validator = Article::validate($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        // Upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('image', 'public');
        }

        $data['views'] = 0;

        $article = Article::create($data);

        // ✅ SIMPAN TAG KE PIVOT
        if ($request->filled('tags')) {
            $article->tags()->sync($request->tags);
        }

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

        // update pivot tags
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('account.article')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function changeStat(Request $request, $id, $status)
    {
        $allowedStatus = ['draft', 'published', 'archived'];

        if (!in_array($status, $allowedStatus)) {
            return back()->withErrors('Status tidak valid');
        }

        $article = Article::findOrFail($id);

        if ($article->status === $status) {
            return back()->with('info', 'Status sudah sama');
        }

        $article->update([
            'status' => $status
        ]);

        return back()->with('success', 'Status artikel berhasil diubah');
    }

    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);
          
            $article->tags()->detach();

            if ($article->image && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }

            $article->delete();
    
            return redirect()
                ->route('account.article')
                ->with('success', 'Article berhasil dihapus.');
        } catch (Exception $e) {
            return back()
                ->with('error', 'Article gagal dihapus.')
                ->withInput();
        }
    }
    //COUNTERS

    //GRAPH
}
