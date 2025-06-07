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

    // Check if either item is already matchedki
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

Public function show($id)
{
    $matching = Matching::with(['lostItem', 'foundItem', 'admin'])->findOrFail($id);
    return view('matching.show', compact('matching'));
}

Public function updateStatus(Request $request, $id)
{
    $matching = Matching::findOrFail($id);

    $validated = $request->validate([
        'status' => 'required|in:pending,cocok,tida cocok',
        'user_confirmation' => 'required|boolean'
    ]);

    // If user confirms the match
if ($validated['user_confirmation']) {
    $matching->update([
        'status' => $validated['status']
    ]);

    // If status is 'cocok', mark both items as matched
    if ($validated['status'] === 'cocok') {
        $matching->lostItem->update(['status' => 'matched']);
        $matching->foundItem->update(['status' => 'matched']);
    }

    return redirect()->route('matching.show', $matching->id)
                ->with('success', 'Status pencocokan berhasil diperbarui');
}


    
