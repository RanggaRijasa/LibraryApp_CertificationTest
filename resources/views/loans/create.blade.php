<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-semibold">Buat Peminjaman</h1>

        @error('books')
            <div class="mt-4 p-3 rounded bg-red-50 text-red-800">{{ $message }}</div>
        @enderror

        <form class="mt-6 space-y-6" method="POST" action="{{ route('loans.store') }}">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm">Anggota</label>
                    <select name="member_id" class="w-full rounded-md border-gray-300">
                        <option value="">-- pilih anggota --</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}" @selected(old('member_id')==$m->id)>
                                {{ $m->name }}{{ $m->member_no ? ' ('.$m->member_no.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('member_id') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="text-sm">Tanggal Pinjam</label>
                    <input type="date" name="loan_date" value="{{ old('loan_date', now()->toDateString()) }}"
                           class="w-full rounded-md border-gray-300" />
                    @error('loan_date') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    <p class="text-xs text-gray-600 mt-1">Jatuh tempo otomatis +7 hari.</p>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold">Pilih Buku (centang)</h2>
                    <input id="filter" class="rounded-md border-gray-300 text-sm" placeholder="filter judul/author/isbn..." />
                </div>

                <div class="mt-3 bg-white shadow rounded-lg overflow-hidden">
                    <table class="w-full text-sm" id="booksTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 text-left">Pilih</th>
                                <th class="p-3 text-left">Judul</th>
                                <th class="p-3 text-left">Author</th>
                                <th class="p-3 text-left">ISBN</th>
                                <th class="p-3 text-right">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($books as $b)
                            <tr class="border-t book-row">
                                <td class="p-3">
                                    <input type="checkbox" name="books[]" value="{{ $b->id }}"
                                           @checked(in_array($b->id, old('books', []))) 
                                           @disabled($b->stock < 1) />
                                </td>
                                <td class="p-3 font-medium book-title">{{ $b->title }}</td>
                                <td class="p-3 book-author">{{ $b->author ?? '-' }}</td>
                                <td class="p-3 book-isbn">{{ $b->isbn }}</td>
                                <td class="p-3 text-right">
                                    <span class="{{ $b->stock < 1 ? 'text-red-600' : '' }}">{{ $b->stock }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @error('books.*') <div class="text-sm text-red-600 mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="flex gap-2">
                <a href="{{ route('loans.index') }}" class="px-4 py-2 rounded-md border">Kembali</a>
                <button class="px-4 py-2 rounded-md bg-black text-white">Simpan Peminjaman</button>
            </div>
        </form>
    </div>

    <script>
        const filter = document.getElementById('filter');
        const rows = document.querySelectorAll('.book-row');

        filter?.addEventListener('input', () => {
            const q = filter.value.toLowerCase();
            rows.forEach(r => {
                const title = r.querySelector('.book-title')?.textContent.toLowerCase() || '';
                const author = r.querySelector('.book-author')?.textContent.toLowerCase() || '';
                const isbn = r.querySelector('.book-isbn')?.textContent.toLowerCase() || '';
                r.style.display = (title.includes(q) || author.includes(q) || isbn.includes(q)) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>
