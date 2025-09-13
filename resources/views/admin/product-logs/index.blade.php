@extends('layouts.admin')

@section('title', 'Product Logs')

@section('content')
<div class="animate-fade-in">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Product Logs</h1>
        <p class="text-gray-600 mt-2">Track all product changes and modifications</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.product-logs.index') }}" class="flex flex-wrap gap-4">
                <!-- Search -->
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Search logs..." 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            value="{{ request('search') }}"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Action Filter -->
                <div class="min-w-[150px]">
                    <select name="action" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Actions</option>
                        <option value="created" {{ request('action') === 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('action') === 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('action') === 'deleted' ? 'selected' : '' }}>Deleted</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <i data-lucide="filter" class="h-4 w-4"></i>
                    Filter
                </button>

                <!-- Clear Filters -->
                @if(request('search') || request('action'))
                <a href="{{ route('admin.product-logs.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Clear
                </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-gray-200">
                    <tr>
                        <th class="text-left p-4 font-medium text-gray-900">Product</th>
                        <th class="text-left p-4 font-medium text-gray-900">Action</th>
                        <th class="text-left p-4 font-medium text-gray-900">Admin User</th>
                        <th class="text-left p-4 font-medium text-gray-900">Changes</th>
                        <th class="text-left p-4 font-medium text-gray-900">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                @if($log->product && $log->product->image)
                                    <img src="{{ $log->product->image_url }}" 
                                         alt="{{ $log->product_name }}" 
                                         class="w-10 h-10 object-cover rounded border">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded border flex items-center justify-center">
                                        <i data-lucide="package" class="h-5 w-5 text-gray-400"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $log->product_name }}</p>
                                    @if($log->product)
                                        <p class="text-sm text-gray-600">ID: {{ $log->product->id }}</p>
                                    @else
                                        <p class="text-sm text-red-600">Product Deleted</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($log->action === 'created') bg-green-100 text-green-800
                                @elseif($log->action === 'updated') bg-blue-100 text-blue-800
                                @elseif($log->action === 'deleted') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                <i data-lucide="
                                    @if($log->action === 'created') plus-circle
                                    @elseif($log->action === 'updated') edit
                                    @elseif($log->action === 'deleted') trash-2
                                    @else activity @endif" class="h-3 w-3 mr-1"></i>
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" class="h-4 w-4 text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $log->user->name ?? 'System' }}</p>
                                    <p class="text-sm text-gray-600">{{ $log->user->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            @if($log->changes && count($log->changes) > 0)
                                <div class="space-y-1">
                                    @foreach($log->changes as $field => $change)
                                        <div class="text-sm">
                                            <span class="font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $field)) }}:</span>
                                            @if(is_array($change))
                                                <span class="text-gray-600">{{ json_encode($change) }}</span>
                                            @else
                                                <span class="text-gray-600">{{ $change }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-500 text-sm">No changes recorded</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="text-sm">
                                <p class="font-medium text-gray-900">{{ $log->created_at->format('M d, Y') }}</p>
                                <p class="text-gray-600">{{ $log->created_at->format('h:i A') }}</p>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">
                            <div class="space-y-2">
                                <i data-lucide="file-text" class="h-12 w-12 mx-auto opacity-50"></i>
                                <p>No logs found</p>
                                <p class="text-sm">Product changes will appear here</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($logs->hasPages())
    <div class="mt-6">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endpush
