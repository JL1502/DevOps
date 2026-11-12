<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Requests</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif

        <div class="bg-white p-6 shadow sm:rounded-lg">
            <form method="GET" action="{{ route('requests.index') }}" class="flex gap-2 mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search item or purpose" class="border rounded px-2 py-1">
                <select name="status" class="border rounded px-2 py-1">
                    <option value="">All statuses</option>
                    @foreach (['pending', 'approved', 'rejected'] as $s)
                        <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-3 py-1 bg-gray-800 text-white rounded">Filter</button>
            </form>

            @can('create', App\Models\ServiceRequest::class)
                <button type="button" onclick="window.location='{{ route('requests.create') }}'" class="mb-4 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    New request
                </button>
            @endcan

            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">ID</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $serviceRequest)
                        <tr class="border-b">
                            <td class="py-2">{{ $serviceRequest->id }}</td>
                            <td>{{ $serviceRequest->item_name }}</td>
                            <td>{{ $serviceRequest->quantity }}</td>
                            <td>{{ $serviceRequest->status }}</td>
                            <td><a href="{{ route('requests.show', $serviceRequest) }}" class="text-blue-600 underline">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-4 text-gray-500">No requests found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">{{ $requests->links() }}</div>
        </div>
    </div>
</x-app-layout>