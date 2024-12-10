<?php

namespace App\Http\Controllers;

use App\Models\CayCanh;
use Illuminate\Http\Request;

class CayCanhController extends Controller
{
    // Hiển thị danh sách cây cảnh
    public function index()
    {
        $cayCanh = CayCanh::all();
        return view('cay_canh.index', compact('cayCanh'));
    }

    // Hiển thị form tạo cây cảnh
    public function create()
    {
        return view('cay_canh.create');
    }

    // Lưu cây cảnh mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'ten_cay' => 'required|max:100',
            'mo_ta' => 'nullable|string|max:255',
            'so_luong' => 'required|integer|min:0',
            'gia' => 'required|numeric|min:0',
            'ngay_tao' => 'nullable|date',
        ]);

        // Tạo mới cây cảnh
        CayCanh::create($request->all());

        // Chuyển hướng về trang danh sách cây cảnh với thông báo thành công
        return redirect()->route('cay_canh.index')->with('success', 'Thêm cây cảnh thành công!');
    }
}
