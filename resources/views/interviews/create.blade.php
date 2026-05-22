<x-app-layout>
    <x-slot name="header">
        Add Interview — {{ $application->company_name }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('interviews.store', $application) }}">
                        @csrf

                        <div class="flex items-center gap-2 mb-5">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Interview Details</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                            <div>
                                <x-input-label for="type" value="Interview Type" />
                                <select id="type" name="type" class="mt-1.5 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($typeOptions as $value => $label)
                                        <option value="{{ $value }}" @selected(old('type') == $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="result" value="Result" />
                                <select id="result" name="result" class="mt-1.5 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">— Not set —</option>
                                    @foreach($resultOptions as $value => $label)
                                        <option value="{{ $value }}" @selected(old('result') == $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('result')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="scheduled_date" value="Date" />
                                <x-text-input id="scheduled_date" name="scheduled_date" type="date" class="mt-1.5 block w-full" :value="old('scheduled_date', date('Y-m-d', strtotime('+1 day')))" required />
                                <x-input-error :messages="$errors->get('scheduled_date')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="scheduled_time" value="Time" />
                                <x-text-input id="scheduled_time" name="scheduled_time" type="time" class="mt-1.5 block w-full" :value="old('scheduled_time', '10:00')" required />
                                <x-input-error :messages="$errors->get('scheduled_time')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mb-5">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Preparation Notes</h3>
                        </div>
                        <div class="mb-6">
                            <textarea id="preparation_notes" name="preparation_notes" rows="4" class="mt-1.5 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Prepare your questions, points to cover...">{{ old('preparation_notes') }}</textarea>
                            <x-input-error :messages="$errors->get('preparation_notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-5 border-t border-gray-100 dark:border-gray-800">
                            <a href="{{ route('applications.show', $application) }}" class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Add Interview
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
