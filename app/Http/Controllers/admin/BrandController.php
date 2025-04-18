<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $request) {
        $brands = Brand::latest('id');

        if ($request->get('keyword')) {
            $brands = $brands->where('name','like','%'.$request->keyword.'%');
        }

        $brands = $brands->paginate(10);

        return view('admin.brands.list', compact('brands'));
    }
    public function create() {
        return view('admin.brands.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:brands',
        ]);

        if ($validator->passes()) {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            session()->flash('success', 'Brand berhasil ditambahkan');

            return response()->json([
                'status' => true,
                'message' => 'Brand berhasil ditambahkan'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id, Request $request) {
        $brand = Brand::find($id);

        if (empty($brand)) {
            session()->flash('error', 'Data tidak ditemukan');
            return redirect()->route('brands.index');
        }

        $data['brand'] = $brand;

        return view('admin.brands.edit',$data);
    }

    public function update($id, Request $request) {

        $brand = Brand::find($id);

        if (empty($brand)) {
            session()->flash('error', 'Data tidak ditemukan');
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$brand->id.',id',
        ]);

        if ($validator->passes()) {
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            session()->flash('success', 'Brand berhasil diperbarui');

            return response()->json([
                'status' => true,
                'message' => 'Brand berhasil diperbarui'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }

    public function destroy($id, Request $request) {
        $brand = Brand::find($id);
        
        if (empty($brand)) {
            session()->flash('error','Data tidak ditemukan');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $brand->delete();

        session()->flash('success','Brand berhasil dihapus.');

        return response([
            'status' => true,
            'message' => 'Brand berhasil dihapus.'
        ]);
    }
}