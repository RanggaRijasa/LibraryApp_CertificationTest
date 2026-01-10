<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['member','staff','items.book'])
            ->latest()
            ->paginate(10);

        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $members = User::where('role', 'member')->orderBy('name')->get(['id','name','member_no']);
        $books = Book::orderBy('title')->get(['id','title','author','stock','isbn']);
        return view('loans.create', compact('members','books'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => ['required','exists:users,id'],
            'loan_date' => ['required','date'],
            'books'     => ['required','array','min:1'],
            'books.*'   => ['integer','exists:books,id'],
        ]);

        return DB::transaction(function () use ($data) {
            $loan = Loan::create([
                'member_id' => $data['member_id'],
                'staff_id'  => auth()->id(),
                'loan_date' => $data['loan_date'],
                'notes'     => null,
            ]);

            $bookIds = array_values(array_unique($data['books']));

            // lock biar stok aman
            $books = Book::whereIn('id', $bookIds)->lockForUpdate()->get();

            foreach ($books as $book) {
                if ($book->stock < 1) {
                    throw ValidationException::withMessages([
                        'books' => "Stok habis: {$book->title}",
                    ]);
                }

                LoanItem::create([
                    'loan_id' => $loan->id,
                    'book_id' => $book->id,
                    'qty'     => 1,
                ]);

                $book->decrement('stock', 1);
            }

            return redirect()->route('loans.index')->with('ok', 'Peminjaman berhasil dibuat.');
        });
    }
}
