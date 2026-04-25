<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('id', 'desc')->get();
        return view('book', compact('books'));
    }

    public function create()
    {
        return view('book_form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'dimension' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        Book::create($request->all());

        return redirect()->route('book.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        return view('book_form', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'dimension' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        $book->update($request->all());

        return redirect()->route('book.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('book.index')->with('success', 'Buku berhasil dihapus.');
    }
}
