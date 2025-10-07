<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data['title'] = env('APP_NAME');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->data['category'] = Category::all();
        $this->data['tags'] = Tag::all();
        $this->data['popular_news'] = $this->popular_new(3);
        
        return view('landing/index', $this->data);
    }

    public function login()
    {
        $this->data['alertMessage'] = '';
        return view('auth/login', $this->data);
    }

    public function popular_new($counter)
    {
        $query = Article::with('category')
        ->where('status','published')
        ->orderBy('views', 'desc')
        ->take($counter)           // batasi jumlah data
        ->get();
        
        foreach ($query as $key ) {
            $key->release = date('F d, Y',strtotime($key->updated_at));
        }
        
        return $query;
    }
}
