<x-app-layout>
    <x-slot name="header">
        Upload Document — {{ $application->company_name }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('documents.store', $application) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="flex items-center gap-2 mb-6">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">File Upload</h3>
                        </div>

                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-10 text-center hover:border-indigo-400 dark:hover:border-indigo-500 transition-colors">
                            <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Drag and drop your file here or click to browse</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mb-4">PDF, DOC, DOCX, XLS, XLSX, JPG, PNG — max 5 MB</p>
                            <input id="file" name="file" type="file" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50 cursor-pointer file:cursor-pointer" required />
                        </div>
                        <x-input-error :messages="$errors->get('file')" class="mt-2" />

                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach(\App\Models\Document::getAllowedTypes() as $mime)
                                @php
                                    $ext = match($mime) {
                                        'application/pdf' => 'PDF',
                                        'application/msword' => 'DOC',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'DOCX',
                                        'application/vnd.ms-excel' => 'XLS',
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'XLSX',
                                        'image/jpeg' => 'JPG',
                                        'image/png' => 'PNG',
                                        'image/gif' => 'GIF',
                                        default => '?',
                                    };
                                @endphp
                                <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 text-xs font-medium rounded">{{ $ext }}</span>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-8 pt-5 border-t border-gray-100 dark:border-gray-800">
                            <a href="{{ route('applications.show', $application) }}" class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
