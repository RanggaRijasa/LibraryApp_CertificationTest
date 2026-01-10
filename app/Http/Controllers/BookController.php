<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $books = Book::query()
            ->when($q, function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('author', 'like', "%{$q}%")
                      ->orWhere('isbn', 'like', "%{$q}%");
            })
            ->orderBy('title')
            ->paginate(10)
            ->withQueryString();

        return view('books.index', compact('books', 'q'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'isbn'   => ['nullable', 'string', 'max:50'],
            'title'  => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'year'   => ['nullable', 'integer', 'min:1000', 'max:' . date('Y')],
            'stock'  => ['required', 'integer', 'min:0'],
        ]);

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'isbn'   => ['nullable', 'string', 'max:50'],
            'title'  => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'year'   => ['nullable', 'integer', 'min:1000', 'max:' . date('Y')],
            'stock'  => ['required', 'integer', 'min:0'],
        ]);

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diupdate.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
