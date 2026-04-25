<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['member', 'books', 'bookReturn'])->orderBy('borrow_date', 'desc')->get();
        return view('borrow', compact('borrowings'));
    }

    public function create()
    {
        $members = Member::orderBy('name')->get();
        $books = Book::where('stock', '>', 0)->orderBy('title')->get();
        return view('borrow_form', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'books' => 'required|array|min:1',
            'books.*.id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
        ]);

        $member = Member::findOrFail($request->member_id);

        // Calculate total requested quantity
        $totalRequestedQuantity = collect($request->books)->sum('quantity');

        // Rule 3: buku tidak boleh melebihi stok limit member
        if ($totalRequestedQuantity > $member->stock) {
            return back()->withErrors(['books' => "Total buku yang dipinjam ($totalRequestedQuantity) melebihi limit stok anggota ({$member->stock})."])->withInput();
        }

        DB::beginTransaction();
        try {
            // Validate book stocks
            $borrowDetails = [];
            foreach ($request->books as $bookReq) {
                $book = Book::findOrFail($bookReq['id']);

                // Rule 1: stok buku harus lebih dari 0 ketika ingin dipinjam
                if ($book->stock < $bookReq['quantity']) {
                    throw new \Exception("Stok buku '{$book->title}' tidak mencukupi. Sisa stok: {$book->stock}");
                }

                $borrowDetails[$book->id] = ['quantity' => $bookReq['quantity']];

                // Decrement book stock
                $book->decrement('stock', $bookReq['quantity']);
            }

            // Create Borrowing
            $borrowing = Borrowing::create([
                'member_id' => $member->id,
                'borrow_date' => $request->borrow_date,
            ]);

            // Attach details
            $borrowing->books()->attach($borrowDetails);

            DB::commit();
            return redirect()->route('borrow.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $borrowing = Borrowing::with(['member', 'books', 'bookReturn'])->findOrFail($id);
        return view('borrow_detail', compact('borrowing'));
    }
}
