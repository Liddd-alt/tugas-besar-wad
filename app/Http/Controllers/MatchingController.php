<?php

namespace App\Http\Controllers;

use App\Models\Matching;
use App\Models\Lost;
use App\Models\Found;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchingController extends Controller
{
    Public function index()
    {
        $matchings = Matching::with(['lostItem', 'foundItem', 'admin'])->get();
        return view('matching.index', compact('matchings'));
    }

public function create()
{
    $lostItems = Lost::whereDoesntHave('matching', function($query) {
            $query->where('status', 'cocok');
    })->get();

    $foundItems = Found::whereDoesntHave('matching', function($query) {
            $query->where('status', 'cocok');
    })->get();

    return view('matching.create', compact('lostItems', 'foundItems'));
}

Public function  store(Request $request)
{
    $validated = $request->validate([
        'lost_id' => 'required|exists:lost,id',
        'found_id' => 'required|exists:found,id',
    ]);

    $existingMatch = Matching::where(function($query) use ($validated) {
        $query->where('lost_id', $validated['lost_id'])
            ->orWhere('found_id', $validated['found_id']);
    })->where('status', 'cocok')->exists();

    if ($existingMatch) {
        return back()->with('error', 'Salah satu item sudah dipasangkan sebelumnya.');
    }

    $validated['admin_id'] = Auth::id();
    $validated['status'] = 'pending';

    Matching::create($validated);

    return redirect()->route('matching.index')->with('success', 'Pencocokan berhasil dibuat.');
}
