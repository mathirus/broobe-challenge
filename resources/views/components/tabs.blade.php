<div class="mb-4 border-b border-gray-200">
    <ul class="flex justify-center flex-wrap -mb-px">
        <li class="mr-2">
            <a href="{{ url('/') }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ request()->is('/') ? 'border-blue-500 text-blue-500' : '' }}">{{ __('messages.current_metrics') }}</a>
        </li>
        <li class="mr-2">
            <a href="{{ url('/history') }}" class="inline-block p-4 border-b-2 rounded-t-lg {{ request()->is('history') ? 'border-blue-500 text-blue-500' : '' }}">{{ __('messages.metrics_history') }}</a>
        </li>
    </ul>
</div>
