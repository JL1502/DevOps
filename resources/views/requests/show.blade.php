<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Request #{{ $serviceRequest->id }}</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <div class="bg-white p-6 shadow sm:rounded-lg space-y-2">
            <p><strong>Requester:</strong> {{ $serviceRequest->requester_name }} ({{ $serviceRequest->requester_email }})</p>
            <p><strong>Item:</strong> {{ $serviceRequest->item_name }}</p>
            <p><strong>Quantity:</strong> {{ $serviceRequest->quantity }}</p>
            <p><strong>Purpose:</strong> {{ $serviceRequest->purpose }}</p>
            <p><strong>Status:</strong> {{ $serviceRequest->status }}</p>

            @can('updateStatus', $serviceRequest)
                <form method="POST" action="{{ route('requests.updateStatus', $serviceRequest) }}" class="flex gap-2 pt-4">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="border rounded px-2 py-1">
                        @foreach (['pending', 'approved', 'rejected'] as $s)
                            <option value="{{ $s }}" @selected($serviceRequest->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-3 py-1 bg-gray-800 text-white rounded">Update status</button>
                </form>
            @endcan

            <a href="{{ route('requests.index') }}" class="inline-block pt-4 text-blue-600 underline">Back to list</a>
        </div>
    </div>
</x-app-layout>
