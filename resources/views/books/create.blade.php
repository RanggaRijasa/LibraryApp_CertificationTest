<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 style="font-size:24px; font-weight:600;">Tambah Buku</h1>

        <form style="margin-top:18px; display:flex; flex-direction:column; gap:14px;"
              method="POST" action="{{ route('books.store') }}">
            @csrf

            <div>
                <label style="font-size:14px;">ISBN</label>
                <input name="isbn" value="{{ old('isbn') }}"
                       style="margin-top:6px; width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px; background:#fff; color:#111827;" />
                @error('isbn') <div style="font-size:13px; color:#dc2626; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label style="font-size:14px;">Judul</label>
                <input name="title" value="{{ old('title') }}"
                       style="margin-top:6px; width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px; background:#fff; color:#111827;" />
                @error('title') <div style="font-size:13px; color:#dc2626; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div>
                <label style="font-size:14px;">Author</label>
                <input name="author" value="{{ old('author') }}"
                       style="margin-top:6px; width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px; background:#fff; color:#111827;" />
                @error('author') <div style="font-size:13px; color:#dc2626; margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div>
                    <label style="font-size:14px;">Tahun</label>
                    <input name="year" value="{{ old('year') }}" type="number"
                           style="margin-top:6px; width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px; background:#fff; color:#111827;" />
                    @error('year') <div style="font-size:13px; color:#dc2626; margin-top:6px;">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label style="font-size:14px;">Stok</label>
                    <input name="stock" value="{{ old('stock',0) }}" type="number"
                           style="margin-top:6px; width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px; background:#fff; color:#111827;" />
                    @error('stock') <div style="font-size:13px; color:#dc2626; margin-top:6px;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:6px;">
                <a href="{{ route('books.index') }}"
                   style="padding:10px 14px; border-radius:8px; border:1px solid #d1d5db; background:#fff; color:#111827; text-decoration:none; display:inline-block;">
                    Batal
                </a>

                <button type="submit"
                        style="padding:10px 14px; border-radius:8px; background:#111827; color:#ffffff; border:none; cursor:pointer;">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
