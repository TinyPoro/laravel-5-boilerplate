<?php

namespace App\Http\Controllers\Backend\Auth\Category;


use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


/**
 * Class RoleController.
 */
class CategoryController extends Controller
{
//    private $categories;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $categories_builder = Category::query();
        if($id = $request->get('id')) $categories_builder->where('id', $id);
        if($name = $request->get('name')) $categories_builder->where('name', 'like', "%$name%");

        $categories = $categories_builder->get();
//        $this->categories = $categories;

        $datas = [];
//        lấy những category gốc
        foreach($categories as $category){
            if(!$category->parent_id) $datas[] = $category->to_array;
        }

//        lấy category con
        foreach($datas as $key => $category_data){
            $cate = Category::find($category_data['id']);
            $datas[$key]['children'] = $cate->children_array;
        }


        return view('backend.auth.category.index', ['datas'=>$datas]);
    }

//    private function getCate($id){
//        foreach($this->categories as $category){
//            if($category->id == $id) return $category;
//        }
//        return null;
//    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        $category = Category::find($id);

        return view('backend.auth.category.show', ['category'=>$category]);
    }

    public function create(){
        return view('backend.auth.category.create');
    }

    public function store(Request $request){
        $name = $request->get('name');
        $static_url = $request->get('static_url');
        $parent_name = $request->get('parent_name');
        $description = $request->get('description');

        $category = new Category();
        $category->name = $name;
        $category->description = $name;
        if($static_url) $category->description = $static_url;
        if($description) $category->description = $description;
        $category->save();
        return redirect()->route('admin.auth.category.index')->withFlashSuccess(__('alerts.backend.category.create'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $category = Category::find($id);

        return view('backend.auth.category.edit', ['category'=>$category]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id){
        $name = $request->get('name');
        $parent_name = $request->get('parent_name');
        $static_url = $request->get('static_url');
        $description = $request->get('description');

        $parent_cate = Category::where('name', $parent_name)->first();

        if(!$parent_cate){
            try{
                $parent_cate = new Category();
                $parent_cate->name = $parent_name;
                $parent_cate->static_url = $static_url;
                $parent_cate->description = $description;
                $parent_cate->save();
            }catch (\Exception $e){
                return redirect()->route('admin.auth.category.index')->withFlashDanger(__('alerts.backend.category.trash_parent'));
            }
        }

        if($id == $parent_cate->id) return redirect()->route('admin.auth.category.index')->withFlashSuccess(__('alerts.backend.category.invalid_parent'));

        $category = Category::find($id);
        $category->name = $name;
        if($category->canHaveParent($parent_cate->id)) $category->parent_id = $parent_cate->id;
        else return redirect()->route('admin.auth.category.index')->withFlashSuccess(__('alerts.backend.category.invalid_parent'));
        $category->save();

        return redirect()->route('admin.auth.category.index')->withFlashSuccess(__('alerts.backend.category.updated'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id){
        Category::find($id)->delete();
        return redirect()->route('admin.auth.category.delete')->withFlashSuccess(__('alerts.backend.category.deleted'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDeleted(){
        $categories = Category::onlyTrashed()->get();

        return view('backend.auth.category.deleted', ['categories'=>$categories]);
    }

    /**
     * @param News $deletedNews
     * @return mixed
     */
    public function delete($deletedCategory)
    {
        Category::where('id', $deletedCategory)->forceDelete();

        return redirect()->route('admin.auth.category.delete')->withFlashSuccess(__('alerts.backend.category.deleted_permanently'));
    }

    /**
     * @param News $deletedNews
     * @return mixed
     */
    public function restore($deletedCategory)
    {
        Category::where('id', $deletedCategory)->restore();

        return redirect()->route('admin.auth.category.index')->withFlashSuccess(__('alerts.backend.category.restored'));
    }
}
