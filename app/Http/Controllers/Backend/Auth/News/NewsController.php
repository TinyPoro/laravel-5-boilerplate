<?php

namespace App\Http\Controllers\Backend\Auth\News;

use App\Category;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\News;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;

/**
 * Class NewsController.
 */
class NewsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $news_builder = News::with('user');

        if($title = $request->get('title')) $news_builder->where('title', 'like', "%$title%");

        if($author = $request->get('author')) {
            $users = User::where('first_name', 'like', "%$author%")
                ->orWhere('last_name', 'like', "%$author%")
                ->get();
            $users_id = [];

            foreach ($users as $user){
                $users_id[] = $user->id;
            }


            $news_builder->whereIn('user_id', $users_id);
        };

        $user = Auth::user();
        if($user->hasRole('author')){
            $news = $news_builder->where('user_id', $user->id)->get();
        }
        else $news = $news_builder->get();

        if($category = $request->get('category')) {
            foreach ($news as $key => $new){
                $flag = 0;

                $categories = $new->categories;
                foreach ($categories as $cate){
                    if ($cate->name == $category) $flag=1;
                }

                if($flag == 0) $news->forget($key);
            }
        };

        return view('backend.auth.news.index', ['news'=>$news]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        $news = News::with('user')->find($id);

        return view('backend.auth.news.show', ['news'=>$news]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $news = News::with('user')->find($id);

        return view('backend.auth.news.edit', ['news'=>$news]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id){

        $title = $request->get('title');
        $content = $request->get('content');
        $categories = explode(',',$request->get('list-cate'));
        $categories = array_filter($categories);

        $news = News::find($id);
        $news->title = $title;
        $news->content = $content;
        $news->save();

        $news->detachAll();

        foreach ($categories as $category){
            $cate = Category::where('name', $category)->first();

            if(!$cate) {
                $cate = new Category();
                $cate->name = $category;
                $cate->save();
            }

          $news->categories()->attach($cate->id);
        }

        return redirect()->route('admin.auth.news.index')->withFlashSuccess(__('alerts.backend.news.updated'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id){
        News::find($id)->delete();
        return redirect()->route('admin.auth.news.delete')->withFlashSuccess(__('alerts.backend.news.deleted'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDeleted(){
        $news = News::onlyTrashed()->get();

        return view('backend.auth.news.deleted', ['news'=>$news]);
    }

    /**
     * @param News $deletedNews
     * @return mixed
     */
    public function delete($deletedNews)
    {
        News::where('id', $deletedNews)->forceDelete();

        return redirect()->route('admin.auth.news.delete')->withFlashSuccess(__('alerts.backend.news.deleted_permanently'));
    }

    /**
     * @param News $deletedNews
     * @return mixed
     */
    public function restore($deletedNews)
    {
        News::where('id', $deletedNews)->restore();

        return redirect()->route('admin.auth.news.index')->withFlashSuccess(__('alerts.backend.news.restored'));
    }
}
