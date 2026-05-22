<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Applications</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $activeApplications }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/30 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Archived</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $archivedApplications }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Upcoming Interviews</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $upcomingInterviews->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Recent Applications --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Recent Applications</h3>
                            <a href="{{ route('applications.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">View all</a>
                        </div>
                    </div>
                    <div class="p-6">
                        @forelse ($recentApplications as $app)
                            <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-800' : '' }}">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center shrink-0">
                                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ substr($app->company_name, 0, 2) }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('applications.show', $app) }}" class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 truncate block">
                                            {{ $app->company_name }}
                                        </a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $app->job_title }}</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 inline-flex text-xs font-medium rounded-full {{ $app->status_color }} shrink-0 ml-3">
                                    {{ $app->status_label }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400">No recent applications.</p>
                                <a href="{{ route('applications.create') }}" class="mt-2 inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Add an application
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Upcoming Interviews --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Upcoming Interviews</h3>
                    </div>
                    <div class="p-6">
                        @forelse ($upcomingInterviews as $interview)
                            <div class="flex items-start gap-4 py-3 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-800' : '' }}">
                                <div class="flex flex-col items-center shrink-0">
                                    <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <a href="{{ route('applications.show', $interview->application) }}" class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400">
                                        {{ $interview->application->company_name }}
                                    </a>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $interview->type_label }}</p>
                                    <div class="flex items-center gap-2 mt-1.5">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $interview->formatted_schedule }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400">No upcoming interviews.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Status Distribution --}}
            @if($statusCounts->isNotEmpty())
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-4">Status Breakdown</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($statusCounts as $status => $count)
                            @php
                                $statusApp = $recentApplications->first(fn($a) => $a->status === $status);
                                $color = $statusApp ? $statusApp->status_color : 'bg-gray-500';
                            @endphp
                            <div class="flex items-center gap-2 px-4 py-2.5 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                                <span class="w-2.5 h-2.5 rounded-full {{ $color }}"></span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ \App\Models\Application::getStatusOptions()[$status] ?? $status }}</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 ml-1">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
