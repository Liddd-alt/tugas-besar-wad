<?php

namespace App\Http\Controllers;

use App\Models\Found;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FoundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $founds = Found::with('category', 'user')->latest()->get();
        } else {
            $founds = Found::with('category', 'user')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }
        return view('found.index', compact('founds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('found.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('image', $imageName);
            $validated['image'] = $imageName;
        }

        $validated['user_id'] = Auth::id();

        Found::create($validated);

        return redirect()->route('found.index')->with('success', 'Data berhasil ditambahkan.');
    }
}
