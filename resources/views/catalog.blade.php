<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-2xl p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Katalog Perpustakaan</h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Cari buku berdasarkan judul, author, atau ISBN. Klik <b>Pinjam (7 hari)</b> untuk meminjam.
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('member.loans.index') }}"
                           class="px-4 py-2 rounded-md border border-gray-300 bg-white text-gray-900 hover:bg-gray-50">
                            Peminjaman Saya
                        </a>

                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                            Dashboard
                        </a>
                    </div>
                </div>

                <form class="mt-6 flex flex-col gap-2 sm:flex-row sm:items-center" method="GET" action="{{ route('catalog') }}">
                    <input
                        type="text"
                        name="q"
                        value="{{ $q }}"
                        placeholder="contoh: Atomic Habits / James Clear / 978..."
                        class="w-full sm:flex-1 rounded-md border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900"
                    />

                    <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 rounded-md border border-gray-300 bg-white text-gray-900 hover:bg-gray-50">
                        Cari
                    </button>
                </form>

                @if(session('ok'))
                    <div class="mt-4 p-3 rounded bg-green-50 text-green-800">
                        {{ session('ok') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mt-4 p-3 rounded bg-red-50 text-red-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="mt-6 overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left p-3 text-gray-700">Judul</th>
                                <th class="text-left p-3 text-gray-700">Author</th>
                                <th class="text-left p-3 text-gray-700">ISBN</th>
                                <th class="text-right p-3 text-gray-700">Stok</th>
                                <th class="text-right p-3 text-gray-700">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @forelse($books as $b)
                                <tr class="border-t">
                                    <td class="p-3 font-medium text-gray-900">{{ $b->title }}</td>
                                    <td class="p-3 text-gray-700">{{ $b->author ?? '-' }}</td>
                                    <td class="p-3 text-gray-700">{{ $b->isbn ?? '-' }}</td>
                                    <td class="p-3 text-right text-gray-900">{{ $b->stock ?? 0 }}</td>
                                    <td class="p-3 text-right whitespace-nowrap">
                                        @if(($b->stock ?? 0) > 0)
                                            <form method="POST" action="{{ route('member.borrow', $b) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="px-3 py-2 rounded-md bg-gray-900 text-white hover:bg-gray-800">
                                                    Pinjam (7 hari)
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-sm text-red-600">Stok habis</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t">
                                    <td colspan="5" class="p-6 text-center text-gray-500">
                                        Tidak ada data buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
