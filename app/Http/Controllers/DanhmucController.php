<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\DanhmucTruyen;
class DanhmucController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $danhmuctruyen = DanhmucTruyen::orderBy('id','DESC')->get();
        return view('admincp.danhmuctruyen.index')->with(compact('danhmuctruyen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admincp.danhmuctruyen.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([
        
            'tendanhmuc'=>'required|unique:danhmuc|max:255',
            'slug_danhmuc'=>'required|unique:danhmuc|max:255',
            'motadanhmuc'=>'required|max:255',
            'kichhoat'=>'required'
        ],
        [
            'tendanhmuc.required'=>'Không được để trống tên danh mục!',
            'tendanhmuc.unique'=>'Tên danh mục đã có xin chọn tên khác!',
            'slug_danhmuc.unique'=>'Slug danh mục đã có xin chọn tên khác!',
            'motadanhmuc.required'=>'Không được để trống phần mô tả!'
        ]
    );
    $data = $request->all();
    $danhmuctruyen = new DanhmucTruyen();
    $danhmuctruyen->tendanhmuc = $data['tendanhmuc'];
    $danhmuctruyen->slug_danhmuc = $data['slug_danhmuc'];
    $danhmuctruyen->motadanhmuc = $data['motadanhmuc'];
    $danhmuctruyen->kichhoat = $data['kichhoat'];
    $danhmuctruyen->save();
    return  redirect()->back()->with('status','Thêm danh mục thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $danhmuc = DanhmucTruyen::find($id);
        return view('admincp.danhmuctruyen.edit')->with(compact('danhmuc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { $danhmuctruyen = DanhmucTruyen::find($id);
        $request->validate([
            'tendanhmuc' =>  ['required',Rule::unique('danhmuc')->ignore($danhmuctruyen->id, 'id')],
           
            'slug_danhmuc'=>'required|max:255',
            'motadanhmuc'=>'required|max:255',
            'kichhoat'=>'required'
        ],
        [
            'tendanhmuc.required'=>'Không được để trống tên danh mục!',
            'slug_danhmuc.required'=>'Không được để trống tên slug danh mục!',
            'motadanhmuc.required'=>'Không được để trống phần mô tả!',
            'tendanhmuc.unique'=>'Tên danh mục đã có xin chọn tên khác!'
        ]
    );
    $data = $request->all();
   
    $danhmuctruyen->tendanhmuc = $data['tendanhmuc'];
    $danhmuctruyen->slug_danhmuc = $data['slug_danhmuc'];
    $danhmuctruyen->motadanhmuc = $data['motadanhmuc'];
    $danhmuctruyen->kichhoat = $data['kichhoat'];
    $danhmuctruyen->save();
    return  redirect()->back()->with('status','Cập nhật danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DanhmucTruyen::find($id)->delete();
        return redirect()-> back()-> with('status', 'Xóa danh mục thành công!');
    }
}
