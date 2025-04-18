<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(Request $request) {
        $subCategories = SubCategory::select('sub_categories.*','categories.name as categoryName')
                            ->latest('sub_categories.id')
                            ->leftJoin('categories','categories.id','sub_categories.category_id');

        if(!empty($request->get('keyword'))) {
            $subCategories = $subCategories->where('sub_categories.name','like','%%'.$request->get('keyword').'%');
            $subCategories = $subCategories->orWhere('categories.name','like','%%'.$request->get('keyword').'%');
        }
        $subCategories = $subCategories->paginate(10);
        return view('admin.sub_category.list',compact('subCategories'));
    }
    public function create() {
        $categories = Category::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        return view('admin.sub_category.create',$data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required',
            'status' => 'required'
        ]);

        if($validator->passes()) {

            $subCategory = new SubCategory();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();

            session()->flash('success','Sub Kategori berhasil dibuat.');

            return response([
                'status' => true,
                'message' => 'Sub Kategori berhasil dibuat.'
            ]);
            
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id, Request $request) {

        $subCategory = SubCategory::find($id);
        if (empty($subCategory)) {
            session()->flash('error','Data tidak ditemukan');
            return redirect()->route('sub-categories.index');
        }

        $categories = Category::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['subCategory'] = $subCategory;
        return view('admin.sub_category.edit',$data);
    }

    public function update($id, Request $request) {
        
        $subCategory = SubCategory::find($id);
        
        if (empty($subCategory)) {
            session()->flash('error','Data tidak ditemukan');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,'.$subCategory->id.',id',
            'category' => 'required',
            'status' => 'required'
        ]);

        if($validator->passes()) {

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();

            session()->flash('success','Sub Kategori berhasil diperbarui.');

            return response([
                'status' => true,
                'message' => 'Sub Kategori berhasil diperbarui.'
            ]);
            
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id, Request $request) {
        $subCategory = SubCategory::find($id);
        
        if (empty($subCategory)) {
            session()->flash('error','Data tidak ditemukan');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $subCategory->delete();

        session()->flash('success','Sub Kategori berhasil dihapus.');

        return response([
            'status' => true,
            'message' => 'Sub Kategori berhasil dihapus.'
        ]);
    }
}