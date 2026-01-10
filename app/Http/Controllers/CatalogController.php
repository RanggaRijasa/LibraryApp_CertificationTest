<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $books = Book::query()
            ->when($q, function ($qr) use ($q) {
                $qr->where('title', 'like', "%{$q}%")
                   ->orWhere('author', 'like', "%{$q}%")
                   ->orWhere('isbn', 'like', "%{$q}%");
            })
            ->orderBy('title')
            ->paginate(10)
            ->withQueryString();

        return view('catalog', compact('books', 'q'));
    }
}
