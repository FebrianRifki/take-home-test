<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookReturn;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function index()
    {
        $returns = BookReturn::with(['borrowing.member'])->orderBy('return_date', 'desc')->get();
        return view('return', compact('returns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'borrowing_id' => 'required|exists:borrowings,id',
        ]);

        $borrowing = Borrowing::with('books')->findOrFail($request->borrowing_id);

        // Check if already returned
        if ($borrowing->bookReturn()->exists()) {
            return back()->withErrors(['error' => 'Peminjaman ini sudah dikembalikan sebelumnya.']);
        }

        DB::beginTransaction();
        try {
            // 1. Insert ke tabel returns
            BookReturn::create([
                'borrowing_id' => $borrowing->id,
                'return_date' => now(),
            ]);

            // 2. Increment stock buku
            foreach ($borrowing->books as $book) {
                // $book->pivot->quantity holds the borrowed quantity
                $quantityBorrowed = $book->pivot->quantity;
                
                // Increment stok
                Book::where('id', $book->id)->increment('stock', $quantityBorrowed);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Buku berhasil dikembalikan dan stok telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengembalikan buku: ' . $e->getMessage()]);
        }
    }
}
