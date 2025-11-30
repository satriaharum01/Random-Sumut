<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
//Models
use App\Models\Tag;
// Etc.
use DataTables;
use Exception;

class AdminTagsController extends Controller
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
        $this->data['title'] = 'Tags Management';
        $this->data['sub_title'] = 'List Tags ' . env('APP_NAME');

        return view('admin/tag/index', $this->data);
    }

    // Query
    public function json()
    {
        $data = Tag::withCount('articles')->orderBy('updated_at', 'DESC')->get();


        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Tag::findorfail($id);

        return json_encode($data);
    }


    //CRUD
    public function storeJson(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:100']);
        $category = Tag::create($validated);

        // Kembalikan JSON untuk update dropdown tanpa reload
        return response()->json($category);
    }

    public function store(Request $request)
    {
        $validator = Tag::validate($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        Tag::create($data);

        return redirect()->route('account.tag')->with('info', 'Tags berhasil disimpan.');
    }

    public function update(Request $request, Tag $post)
    {
        $validator = Tag::validate($request->all(), $post->id);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        $post->update($data);

        return redirect()->route('account.tag')->with('success', 'Tags berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $category = Tag::findOrFail($id);
            $category->delete();

            return redirect()
                ->route('account.tag')
                ->with('delete', 'Tags berhasil dihapus.');
        } catch (Exception $e) {
            return back()
                ->with('warning', 'Tags gagal dihapus.')
                ->withInput();
        }
    }

    //COUNTERS

    //GRAPH
}
