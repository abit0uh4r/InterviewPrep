<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Domain
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded border border-gray-200 bg-white p-6">
                <form method="POST" action="{{ route('domains.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium text-gray-700">Domain name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            class="block w-full rounded border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ex: Laravel ORM"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="color" class="mb-1 block text-sm font-medium text-gray-700">Badge color</label>
                        <input
                            id="color"
                            name="color"
                            type="color"
                            value="{{ old('color', '#2563eb') }}"
                            class="h-10 w-16 rounded border-gray-300 p-1 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                        @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="submit"
                            class="inline-flex items-center rounded border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                        >
                            Save
                        </button>
                        <a href="{{ route('domains.index') }}" class="text-sm text-gray-600 hover:underline">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
