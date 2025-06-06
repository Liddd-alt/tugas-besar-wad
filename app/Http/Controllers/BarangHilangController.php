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