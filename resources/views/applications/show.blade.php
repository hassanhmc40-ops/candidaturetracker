<x-app-layout>
    <x-slot name="header">
        {{ $application->company_name }}
    </x-slot>
    <x-slot name="headerAction">
        <div class="flex items-center gap-2">
            @can('update', $application)
                <a href="{{ route('applications.edit', $application) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
            @endcan
            @can('delete', $application)
                <form method="POST" action="{{ route('applications.destroy', $application) }}" class="inline" onsubmit="return confirm('Archive this application? It can be restored from the archives.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        Archive
                    </button>
                </form>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Application Details Card --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $application->company_name }}</h3>
                            <p class="text-base text-gray-500 dark:text-gray-400 mt-1">{{ $application->job_title }}</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-full {{ $application->status_color }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/40"></span>
                                {{ $application->status_label }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-full {{ $application->priority_color }}">
                                {{ $application->priority_label }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Application Date</span>
                            <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $application->application_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Interviews</span>
                            <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $application->interviews->count() }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Documents</span>
                            <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $application->documents->count() }}</p>
                        </div>
                        @if ($application->job_url)
                            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Job Posting</span>
                                <p class="mt-1">
                                    <a href="{{ $application->job_url }}" target="_blank" class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                        View posting
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>

                    @if ($application->notes)
                        <div class="mt-6 bg-gray-50 dark:bg-gray-800/50 rounded-lg p-5 border-l-4 border-indigo-400 dark:border-indigo-600">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Notes</span>
                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">{{ $application->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Interviews Section --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="px-6 sm:px-8 py-5 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Interviews ({{ $application->interviews->count() }})</h3>
                        </div>
                        @can('update', $application)
                            <a href="{{ route('interviews.create', $application) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 border border-transparent rounded-lg font-medium text-xs text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Add
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    @forelse ($application->interviews->sortBy('scheduled_date') as $interview)
                        <div class="relative pl-8 pb-6 {{ !$loop->last ? 'border-l-2 border-gray-200 dark:border-gray-700' : '' }}">
                            <div class="absolute left-0 top-0 -translate-x-1/2 w-4 h-4 rounded-full border-2 {{ $interview->result === 'reussi' ? 'bg-emerald-500 border-emerald-500' : ($interview->result === 'echoue' ? 'bg-red-500 border-red-500' : 'bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-600') }}"></div>
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $interview->type_label }}</span>
                                        @if ($interview->isToday())
                                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 rounded-full">Today</span>
                                        @elseif ($interview->isUpcoming())
                                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-full">Upcoming</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $interview->formatted_schedule }}</p>
                                    @if ($interview->preparation_notes)
                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 whitespace-pre-wrap bg-gray-50 dark:bg-gray-800/50 rounded-lg p-3">{{ $interview->preparation_notes }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    @if ($interview->result)
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $interview->result_color }}">{{ $interview->result_label }}</span>
                                    @endif
                                    <a href="{{ route('interviews.edit', $interview) }}" class="p-1.5 text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('interviews.destroy', $interview) }}" class="inline" onsubmit="return confirm('Delete this interview?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 dark:hover:text-red-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" title="Delete">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No interviews recorded for this application.</p>
                            @can('update', $application)
                                <a href="{{ route('interviews.create', $application) }}" class="mt-3 inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Add an interview
                                </a>
                            @endcan
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Documents Section --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="px-6 sm:px-8 py-5 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Documents ({{ $application->documents->count() }})</h3>
                        </div>
                        @can('update', $application)
                            <a href="{{ route('documents.create', $application) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 border border-transparent rounded-lg font-medium text-xs text-white shadow-sm hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Add
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    @forelse ($application->documents as $document)
                        <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-800' : '' }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $document->file_name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $document->formatted_size }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 ml-3">
                                <a href="{{ route('documents.download', $document) }}" class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" title="Download">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </a>
                                <form method="POST" action="{{ route('documents.destroy', $document) }}" class="inline" onsubmit="return confirm('Delete this document?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No documents attached.</p>
                            @can('update', $application)
                                <a href="{{ route('documents.create', $application) }}" class="mt-3 inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Upload a document
                                </a>
                            @endcan
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
