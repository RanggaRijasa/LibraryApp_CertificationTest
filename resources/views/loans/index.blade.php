<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Data Peminjaman</h1>
            <a href="{{ route('loans.create') }}" class="px-4 py-2 rounded-md bg-black text-white">
                + Buat Peminjaman
            </a>
        </div>

        @if(session('ok'))
            <div class="mt-4 p-3 rounded bg-green-50 text-green-800">{{ session('ok') }}</div>
        @endif

        <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-3">Anggota</th>
                        <th class="text-left p-3">Petugas</th>
                        <th class="text-left p-3">Tgl Pinjam</th>
                        <th class="text-left p-3">Jatuh Tempo</th>
                        <th class="text-left p-3">Buku</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($loans as $l)
                    <tr class="border-t">
                        <td class="p-3 font-medium">{{ $l->member->name ?? '-' }}</td>
                        <td class="p-3">{{ $l->staff->name ?? '-' }}</td>
                        <td class="p-3">{{ $l->loan_date?->format('Y-m-d') }}</td>
                        <td class="p-3">{{ $l->due_date?->format('Y-m-d') }}</td>
                        <td class="p-3">
                            <ul class="list-disc pl-5">
                                @foreach($l->items as $it)
                                    <li>{{ $it->book->title ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $loans->links() }}</div>
    </div>
</x-app-layout>
