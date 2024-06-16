<form id="metricsForm" class="space-y-4">
    <div class="flex space-x-4">
        <div class="w-2/3">
            <label for="url" class="block text-sm font-medium text-gray-700">{{ __('messages.url') }}</label>
            <div class="flex">
                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">http://</span>
                <input type="text" id="url" name="url" class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-r-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="{{ __('messages.example_url') }}">
            </div>
        </div>
        <div class="w-1/3">
            <label for="strategy" class="block text-sm font-medium text-gray-700">{{ __('messages.strategy') }}</label>
            <select id="strategy" name="strategy" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="1">{{ __('messages.desktop') }}</option>
                <option value="2">{{ __('messages.mobile') }}</option>
            </select>
        </div>
    </div>
    <div class="flex justify-between items-center">
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.categories') }}</label>
            <div class="mt-2 space-y-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="categories[]" value="1" class="form-checkbox text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="ml-2 text-gray-700">{{ __('messages.accessibility') }}</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="checkbox" name="categories[]" value="2" class="form-checkbox text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="ml-2 text-gray-700">{{ __('messages.best_practices') }}</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="checkbox" name="categories[]" value="3" class="form-checkbox text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="ml-2 text-gray-700">{{ __('messages.performance') }}</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="checkbox" name="categories[]" value="4" class="form-checkbox text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="ml-2 text-gray-700">{{ __('messages.pwa') }}</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="checkbox" name="categories[]" value="5" class="form-checkbox text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="ml-2 text-gray-700">{{ __('messages.seo') }}</span>
                </label>
            </div>
        </div>
        <div class="flex space-x-4">
            <button type="button" id="saveMetrics" class="bg-white text-indigo-600 font-bold py-2 px-4 rounded border border-indigo-600 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hidden">{{ __('messages.save_metrics') }}</button>
            <button type="button" id="fetchMetrics" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('messages.fetch_metrics') }}</button>
        </div>
    </div>
</form>

<style>
    .loading {
        cursor: not-allowed;
        opacity: 0.6;
    }
    .loading-icon {
        display: inline-block;
        margin-left: 10px;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.6);
        border-top: 2px solid #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
