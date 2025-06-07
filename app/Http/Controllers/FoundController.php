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
}
