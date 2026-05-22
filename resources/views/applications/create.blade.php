<x-app-layout>
    <x-slot name="header">
        New Application
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('applications.store') }}">
                        @csrf

                        {{-- Section: Basic Info --}}
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-5">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">General Information</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <x-input-label for="company_name" value="Company" />
                                    <x-text-input id="company_name" name="company_name" type="text" class="mt-1.5 block w-full" :value="old('company_name')" required placeholder="Company name" />
                                    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="job_title" value="Job Title" />
                                    <x-text-input id="job_title" name="job_title" type="text" class="mt-1.5 block w-full" :value="old('job_title')" required placeholder="Position title" />
                                    <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Section: Workflow --}}
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-5">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tracking</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <x-input-label for="status" value="Status" />
                                    <select id="status" name="status" class="mt-1.5 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach($statusOptions as $value => $label)
                                            <option value="{{ $value }}" @selected(old('status') == $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="priority" value="Priority" />
                                    <select id="priority" name="priority" class="mt-1.5 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach($priorityOptions as $value => $label)
                                            <option value="{{ $value }}" @selected(old('priority') == $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="application_date" value="Application Date" />
                                    <x-text-input id="application_date" name="application_date" type="date" class="mt-1.5 block w-full" :value="old('application_date', date('Y-m-d'))" required />
                                    <x-input-error :messages="$errors->get('application_date')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="job_url" value="Job Posting URL (optional)" />
                                    <x-text-input id="job_url" name="job_url" type="url" class="mt-1.5 block w-full" :value="old('job_url')" placeholder="https://..." />
                                    <x-input-error :messages="$errors->get('job_url')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Section: Notes --}}
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-5">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Notes</h3>
                            </div>
                            <div>
                                <textarea id="notes" name="notes" rows="4" class="mt-1.5 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Additional information...">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-5 border-t border-gray-100 dark:border-gray-800">
                            <a href="{{ route('applications.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Create Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
