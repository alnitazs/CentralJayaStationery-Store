<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::latest();

        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name', 'like', '%%' . $request->get('keyword') . '%');
        }
        $categories = $categories->paginate(10);
        return view('admin.category.list', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);

        if ($validator->passes()) {

            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->image = $request->image ?? null;
            $category->save();

            //Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id . '.' . $ext;
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/category/' . $newImageName;
                File::copy($sPath, $dPath);

                //Generate Image Thumbnail
                $dPath = public_path() . '/uploads/category/thumb/' . $newImageName;
                $manager = new ImageManager(new Driver());

                $image = $manager->read($sPath);
                $image->cover(450, 600);
                $image->save($dPath);

                $category->image = $newImageName;
                $category->save();
            }

            session()->flash('success', 'Category added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category added successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        if (empty($category)) {
            return redirect()->route('categories.index');
        }
        return view('admin.category.edit', compact('category'));
    }

    public function update($categoryId, Request $request)
    {

        $category = Category::find($categoryId);

        if (empty($category)) {
            session()->flash('error', 'Category not found');

            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category not found'
            ]);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $category->id . ',id',
        ]);

        if ($validator->passes()) {

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->image = $request->image ?? null;
            $category->save();

            $oldImage = $category->image;

            //Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id . '-' . time() . '.' . $ext;
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/category/' . $newImageName;
                File::copy($sPath, $dPath);

                //Generate Image Thumbnail
                $dPath = public_path() . '/uploads/category/thumb/' . $newImageName;
                $manager = new ImageManager(new Driver());

                $image = $manager->read($sPath);
                $image->cover(450, 600);
                $image->save($dPath);

                $category->image = $newImageName;
                $category->save();

                //Delete Old Image Here
                if (!empty($oldImage)) {
                    if (File::exists(public_path() . '/uploads/category/' . $oldImage)) {
                        File::delete(public_path() . '/uploads/category/' . $oldImage);
                    }
                    if (File::exists(public_path() . '/uploads/category/thumb/' . $oldImage)) {
                        File::delete(public_path() . '/uploads/category/thumb/' . $oldImage);
                    }
                }
            }

            session()->flash('success', 'Category updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($categoryId, Request $request)
    {
        $category = Category::find($categoryId);

        if (empty($category)) {

            session()->flash('error', 'Category not found');

            return response()->json([
                'status' => false,
                'message' => 'Category not found'

            ]);
        }

        if (!empty($category->image)) {
            if (File::exists(public_path() . '/uploads/category/' . $category->image)) {
                File::delete(public_path() . '/uploads/category/' . $category->image);
            }
            if (File::exists(public_path() . '/uploads/category/thumb/' . $category->image)) {
                File::delete(public_path() . '/uploads/category/thumb/' . $category->image);
            }
        }

        $category->delete();

        session()->flash('success', 'Category deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'

        ]);
    }
}
