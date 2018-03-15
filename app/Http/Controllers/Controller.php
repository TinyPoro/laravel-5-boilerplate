<?php

namespace App\Http\Controllers;

use App\Category;
use App\News;
use function GuzzleHttp\Promise\all;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Auth;

/**
 * Class Controller.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function forum(Request $request){
        if($category = $request->get('category')){
            $news = News::with('categories')
                ->whereHas('categories', function($query) use ($category){
                    $query->where('name', 'like', "%$category%");
                })->get();
        }else $news = News::all();

        $top_cate = DB::table('category_news')->selectRaw('category_id, COUNT(*) as count')
            ->groupBy('category_id')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        foreach ($top_cate as $key => $cate) {
            $top_cate[$key]->name = Category::find($cate->category_id)->name;
        }

        return view('frontend.forum', ['news'=>$news, 'top_cate'=>$top_cate]);
    }

    public function createNews(){
        $categories = Category::all();
        return view('frontend.createNews', ['categories' => $categories]);
    }

    public function storeNews(Request $request){
        $user = Auth::user();

        $title = $request->get('title');
        $content = $request->get('content');
        $categories = explode(',', $request->get('category'));
        $categories = array_filter($categories);
        $file = $request->file('image');
        $status = $request->get('status');
        $look_mode = $request->get('look_mode');
        $password = $request->get('password');
//        $post_mode = $request->get('post_mode');

        $news = new News();
        $news->user_id = $user->id;
        $news->title = $title;
        $news->content = $content;
        $news->ava_path = $file->getClientOriginalName();
        $news->status = $status;
        $news->look_mode = $look_mode;
        $news->password = $password;
//        $news->post_mode = $post_mode;
        $news->save();

        foreach ($categories as $category){
            $cate = Category::where('name', $category)->first();

            if(!$cate) {
                $cate = new Category();
                $cate->name = $category;
                $cate->save();
            }

            $news->categories()->attach($cate->id);
        }



        return route('/forum');
    }

    public function check_pass(Request $request){
        $password = $request->get('password');
        $id = $request->get('id');

        $news = News::find($id);
        if($news->password == $password) return $id;
        else return "pass sai mịa rùi";
    }

    public function delete_news(Request $request){
        $choosen_id = $request->get('choosen_id');

        foreach ($choosen_id as $id){
            News::find($id)->delete();
        }
        return $choosen_id;
    }
}
