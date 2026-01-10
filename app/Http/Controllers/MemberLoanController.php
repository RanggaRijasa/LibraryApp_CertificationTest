<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberLoanController extends Controller
{
    /**
     * List peminjaman milik member yang sedang login
     */
    public function index(Request $request)
    {
        $loans = Loan::with('items.book')
            ->where('member_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('member.loans', compact('loans'));
    }


    public function borrow(Request $request, Book $book)
    {
        // basic check
        if (($book->stock ?? 0) <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }



        DB::transaction(function () use ($book) {
            $loan = Loan::create([
                'member_id' => auth()->id(),
                'staff_id'  => null, // member pinjam mandiri, staff belum input
                'loan_date' => now()->toDateString(), // due_date akan auto +7 hari di model
                'notes'     => null,
            ]);

            LoanItem::create([
                'loan_id' => $loan->id,
                'book_id' => $book->id,
                'qty'     => 1,
            ]);

            $book->decrement('stock', 1);
        });

        return redirect()->route('member.loans.index')
            ->with('success', 'Berhasil pinjam. Batas kembali 7 hari dari tanggal pinjam.');
    }
}
