<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CardController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $cards = auth()->user()->cards()->get();
        return view('dashboard', compact('cards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:ToDo,InProgress,Testing,Done',
        ]);

        auth()->user()->cards()->create($request->only('title', 'status'));

        return back()->with('success','Created Successfully');
    }

    public function updateStatus(Request $request, Card $card)
    {
        $this->authorize('update', $card); // Only allow user to update his card
        $request->validate([
            'status' => 'required|in:ToDo,InProgress,Testing,Done',
        ]);

        $card->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function destroy(Card $card)
    {
        $this->authorize('delete', $card);
        $card->delete();

        return back()->with('success','Deleted Successfully');
    }
    public function updateTitle(Request $request, Card $card)
    {
        $card->update(['title' => $request->title]);
        return response()->json(['success' => true]);
    }

}
