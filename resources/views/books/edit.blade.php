<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-semibold">Edit Buku</h1>

        <form class="mt-6 space-y-4" method="POST" action="{{ route('books.update',$book) }}">
            @csrf @method('PUT')

            <div>
                <label class="text-sm">ISBN</label>
                <input name="isbn" value="{{ old('isbn',$book->isbn) }}" class="w-full rounded-md border-gray-300" />
                @error('isbn') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="text-sm">Judul</label>
                <input name="title" value="{{ old('title',$book->title) }}" class="w-full rounded-md border-gray-300" />
                @error('title') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="text-sm">Author</label>
                <input name="author" value="{{ old('author',$book->author) }}" class="w-full rounded-md border-gray-300" />
                @error('author') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm">Tahun</label>
                    <input name="year" value="{{ old('year',$book->year) }}" type="number" class="w-full rounded-md border-gray-300" />
                    @error('year') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="text-sm">Stok</label>
                    <input name="stock" value="{{ old('stock',$book->stock) }}" type="number" class="w-full rounded-md border-gray-300" />
                    @error('stock') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('books.index') }}" class="px-4 py-2 rounded-md border">Batal</a>
                <button class="px-4 py-2 rounded-md bg-black text-white">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
