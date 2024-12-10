<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CayCanhController extends Controller
{
     public function index()
    {
        $cayCanh = CayCanh::all();
        return view('caycanh.index', compact('cayCanh'));
    }

    public function create()
    {
        return view('caycanh.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_cay' => 'required|unique:cay_canh|max:50',
            'ten_cay' => 'required|max:255',
            'gia' => 'required|numeric',
            'so_luong' => 'required|integer|min:0'
        ]);

        CayCanh::create($request->all());
        return redirect()->route('caycanh.index');
    }
}
