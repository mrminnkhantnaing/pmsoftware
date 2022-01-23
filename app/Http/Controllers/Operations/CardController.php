<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CardController extends Controller
{
    // Show All Cards
    public function index() {
        $cards = Cache::remember('cards-index', now()->addDay(), function() {
            return Card::orderBy('code', 'desc')->get();
        });

        $availableCardsCount = Card::where('status', 'available')->count();
        $activeCardsCount = Card::where('status', 'active')->count();
        $lostCardsCount = Card::where('status', 'lost')->count();

        return view('operations.cards.index', compact('cards', 'availableCardsCount', 'activeCardsCount', 'lostCardsCount'));
    }

    // Show Available Cards
    public function availableCards() {
        $cardsCount = Card::count();
        $availableCards = Card::orderBy('code', 'desc')->where('status', 'available')->get();
        $availableCardsCount = Card::where('status', 'available')->count();
        $activeCardsCount = Card::where('status', 'active')->count();
        $lostCardsCount = Card::where('status', 'lost')->count();

        return view('operations.cards.availableCards', compact('cardsCount', 'availableCards', 'availableCardsCount', 'activeCardsCount', 'lostCardsCount'));
    }

    // Show Active Cards
    public function activeCards() {
        $activeCards = Card::orderBy('code', 'desc')->where('status', 'active')->get();
        $cardsCount = Card::count();
        $cards = Card::orderBy('code', 'desc')->where('status', '!=', 'active')->get();
        $availableCardsCount = Card::where('status', 'available')->count();
        $activeCardsCount = Card::where('status', 'active')->count();
        $lostCardsCount = Card::where('status', 'lost')->count();

        return view('operations.cards.activeCards', compact('cardsCount', 'activeCards', 'cards', 'availableCardsCount', 'activeCardsCount', 'lostCardsCount'));
    }

    // Show Lost Cards
    public function lostCards() {
        $lostCards = Card::orderBy('code', 'desc')->where('status', 'lost')->get();
        $cardsCount = Card::count();
        $cards = Card::orderBy('code', 'desc')->where('status', '!=', 'lost')->get();
        $availableCardsCount = Card::where('status', 'available')->count();
        $activeCardsCount = Card::where('status', 'active')->count();
        $lostCardsCount = Card::where('status', 'lost')->count();

        return view('operations.cards.lostCards', compact('cardsCount', 'lostCards', 'cards', 'availableCardsCount', 'activeCardsCount', 'lostCardsCount'));
    }

    // Store Card
    public function store(Request $request) {
        $request->validate([
            'code' => 'required|unique:cards,code'
        ],
        [
            'code.required' => 'Card ID field must not be empty when you add a new card!',
            'code.unique' => 'Card ID field should be unique when you add a new card!',
        ]);

        Card::create([
            'code' => $request->code,
            'status' => 'available',
        ]);

        return redirect()->route('cards.index')->with('success', 'You have successfully created a new card!');
    }

    // Show Single Card
    public function show($id) {
        $card = Card::findOrFail($id);

        return view('operations.cards.index', compact('card'));
    }

    // Update Card
    public function update(Request $request, $id) {
        $request->validate([
            'code' => 'required',
            'status' => 'required'
        ]);

        $card = Card::findOrFail($id);
        $card->update([
            'code' => $request->code,
            'status' => $request->status,
        ]);

        return redirect()->route('cards.index')->with('success', 'You have successfully updated a card!');
    }

    // Destroy Card
    public function destroy($id) {
        Card::findOrFail($id)->delete();

        return redirect()->route('cards.index')->with('success', 'You have successfully deleted a card!');
    }
}
