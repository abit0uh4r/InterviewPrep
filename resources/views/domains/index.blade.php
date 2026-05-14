<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Domains
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">My Domains</h3>
                <a
                    href="{{ route('domains.create') }}"
                    class="inline-flex items-center rounded border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                >
                    New Domain
                </a>
            </div>

            <div class="overflow-hidden rounded border border-gray-200 bg-white">
                <div class="p-4">
                    @forelse ($domains as $domain)
                        <div class="flex items-center justify-between border-b border-gray-100 py-3 last:border-b-0">
                            <div class="flex items-center gap-3">
                                <span
                                    class="inline-block h-3 w-3 rounded-full"
                                    style="background-color: {{ $domain->color }}"
                                    aria-hidden="true"
                                ></span>
                                <span class="font-medium text-gray-900">{{ $domain->name }}</span>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('domains.edit', $domain) }}" class="text-sm text-indigo-600 hover:underline">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('domains.destroy', $domain) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="text-sm text-red-600 hover:underline"
                                        onclick="return confirm('Delete this domain?');"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600">No domains yet. Create your first one.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
