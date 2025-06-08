<?php

namespace App\Http\Controllers;

use App\Models\Lost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LostController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $losts = Lost::with('category', 'user')->latest()->get();
        } else {
            $losts = Lost::with('category', 'user')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }
        return view('lost.index', compact('losts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('lost.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'category_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('image', $imageName);
            $validated['image'] = $imageName;
        }

        $validated['user_id'] = Auth::id();

        $lost = Lost::create($validated);

        return redirect()->route('lost.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $lost = Lost::with(['category', 'user'])->findOrFail($id);
        return view('lost.show', compact('lost'));
    }

    public function edit($id)
    {
        $lost = Lost::findOrFail($id);
        $categories = Category::all();
        return view('lost.update', compact('lost', 'categories'));
    }