<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:center; justify-content:space-between;">
            <h1 style="font-size:24px; font-weight:600;">Master Buku</h1>

            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                <form method="GET" action="{{ route('books.index') }}" style="display:flex; gap:10px; align-items:center;">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari judul / author / ISBN..."
                        style="width:260px; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px; background:#fff; color:#111827;"
                    />

                    <button type="submit"
                        style="padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; background:#fff; color:#111827; cursor:pointer;">
                        Cari
                    </button>
                </form>

                <a href="{{ route('books.create') }}"
                   style="padding:10px 14px; border-radius:8px; background:#111827; color:#ffffff; text-decoration:none; display:inline-block;">
                    + Tambah Buku
                </a>
            </div>
        </div>

        @if(session('ok'))
            <div style="margin-top:16px; padding:12px; border-radius:8px; background:#ecfdf5; color:#065f46;">
                {{ session('ok') }}
            </div>
        @endif
        @if(session('success'))
            <div style="margin-top:16px; padding:12px; border-radius:8px; background:#ecfdf5; color:#065f46;">
                {{ session('success') }}
            </div>
        @endif

        <div style="margin-top:18px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
            <table style="width:100%; font-size:14px; border-collapse:collapse;">
                <thead style="background:#f9fafb;">
                    <tr>
                        <th style="text-align:left; padding:12px;">Judul</th>
                        <th style="text-align:left; padding:12px;">Author</th>
                        <th style="text-align:left; padding:12px;">ISBN</th>
                        <th style="text-align:left; padding:12px;">Tahun</th>
                        <th style="text-align:right; padding:12px;">Stok</th>
                        <th style="text-align:right; padding:12px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($books as $b)
                        <tr style="border-top:1px solid #e5e7eb;">
                            <td style="padding:12px; font-weight:600;">{{ $b->title }}</td>
                            <td style="padding:12px;">{{ $b->author ?? '-' }}</td>
                            <td style="padding:12px;">{{ $b->isbn ?? '-' }}</td>
                            <td style="padding:12px;">{{ $b->year ?? '-' }}</td>
                            <td style="padding:12px; text-align:right;">{{ $b->stock ?? 0 }}</td>
                            <td style="padding:12px; text-align:right; white-space:nowrap;">
                                <a href="{{ route('books.edit',$b) }}" style="text-decoration:underline; color:#111827;">Edit</a>

                                <form style="display:inline;" method="POST" action="{{ route('books.destroy',$b) }}"
                                      onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="margin-left:12px; background:transparent; border:none; color:#dc2626; text-decoration:underline; cursor:pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr style="border-top:1px solid #e5e7eb;">
                            <td colspan="6" style="padding:18px; text-align:center; color:#6b7280;">
                                Belum ada data buku.
                                <a href="{{ route('books.create') }}" style="text-decoration:underline; color:#111827;">Tambah buku</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $books->links() }}
        </div>
    </div>
</x-app-layout>
