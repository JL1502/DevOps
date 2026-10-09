<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New request</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <div class="bg-white p-6 shadow sm:rounded-lg">
            <form method="POST" action="{{ route('requests.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label>Item name</label><br>
                    <input type="text" name="item_name" value="{{ old('item_name') }}" maxlength="150" required class="border rounded px-2 py-1 w-full">
                </div>
                <div>
                    <label>Quantity</label><br>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" min="1" required class="border rounded px-2 py-1 w-full">
                </div>
                <div>
                    <label>Purpose</label><br>
                    <textarea name="purpose" maxlength="2000" required class="border rounded px-2 py-1 w-full">{{ old('purpose') }}</textarea>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Create request
                    </button>
                    <a href="{{ route('requests.index') }}" class="text-sm font-medium text-blue-600 underline hover:text-blue-500">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>