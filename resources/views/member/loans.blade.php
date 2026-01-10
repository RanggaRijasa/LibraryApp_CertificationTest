<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Peminjaman Saya</h1>

            <a href="{{ route('catalog') }}"
               style="padding:10px 14px;border-radius:8px;border:1px solid #d1d5db;background:#fff;color:#111827;text-decoration:none;">
                ← Kembali ke Katalog
            </a>
        </div>

        @if(session('success'))
            <div style="margin-top:14px;padding:12px;border-radius:8px;background:#ecfdf5;color:#065f46;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="margin-top:14px;padding:12px;border-radius:8px;background:#fef2f2;color:#991b1b;">
                {{ session('error') }}
            </div>
        @endif

        <div style="margin-top:18px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <thead style="background:#f9fafb;">
                    <tr>
                        <th style="text-align:left;padding:12px;">Tanggal Pinjam</th>
                        <th style="text-align:left;padding:12px;">Batas Kembali</th>
                        <th style="text-align:left;padding:12px;">Status</th>
                        <th style="text-align:left;padding:12px;">Buku</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr style="border-top:1px solid #e5e7eb;">
                            <td style="padding:12px;">
                                {{ optional($loan->loan_date)->format('d/m/Y') }}
                            </td>

                            <td style="padding:12px;font-weight:600;">
                                {{ optional($loan->due_date)->format('d/m/Y') }}
                            </td>

                            <td style="padding:12px;">
                                {{ $loan->returned_at ? 'Returned' : 'Borrowed' }}
                                @if(method_exists($loan,'isOverdue') && $loan->isOverdue())
                                    <span style="color:#dc2626;font-weight:700;">(Terlambat)</span>
                                @endif
                            </td>

                            <td style="padding:12px;">
                                @foreach($loan->items as $it)
                                    <div>{{ $it->book->title ?? '-' }} (x{{ $it->qty }})</div>
                                @endforeach
                            </td>
                        </tr>
                    @empty
                        <tr style="border-top:1px solid #e5e7eb;">
                            <td colspan="4" style="padding:16px;text-align:center;color:#6b7280;">
                                Belum ada peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $loans->links() }}
        </div>
    </div>
</x-app-layout>
