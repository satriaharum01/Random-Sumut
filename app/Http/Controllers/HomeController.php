<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
//Models
use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Category;
use App\Models\Comment;
use App\Models\FeaturedArticle;
use App\Models\Tag;
use App\Models\User;
//Etc.
use DataTables;

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
        $this->data['popular_news'] = $this->popularNews(3);
        $this->data['latest_news'] = $this->latestNews(4);
        
        //return($this->data['latest_news'] );
        return view('landing/index', $this->data);
    }

    public function login()
    {
        $this->data['alertMessage'] = '';
        return view('auth/login', $this->data);
    }

    public function popularNews($counter)
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
    
    public function featuredNews($counter)
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
    
    public function latestNews($counter)
    {
        $query = Article::with(['category','author'])->withCount('comments')
        ->where('status','published')
        ->orderBy('updated_at', 'desc')
        ->take($counter)           // batasi jumlah data
        ->get();
        foreach ($query as $key ) {
            $content = strip_tags($key->content);
            $key->subtitle = collect(explode("\n", wordwrap($content, 80)))
                          ->take(2)
                          ->implode(' ');
            $key->release = date('F d, Y',strtotime($key->updated_at));
        }
        
        return $query;
    }

    
    /*
     * Berita Function
    */
    public function bacaBerita($slug)
    {
        $tags;
        $query = Article::with(['category','author','tags'])->withCount('comments')
        ->where('slug',$slug)
        ->get();
        
        foreach ($query as $key ) {
            $key->release = date('F d, Y',strtotime($key->updated_at));
            $tags = $key->tags;
        }
        
        $this->data['news'] = $query;

        $this->data['popular_news'] = $this->popularNews(3);
        $this->data['category'] = Category::all();
        $this->data['tags'] = $tags;
        
        return view('landing/singlePage', $this->data);
    }
}
