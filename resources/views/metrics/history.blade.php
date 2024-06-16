@extends('layouts.app')

@section('title', __('messages.metrics_history'))

@section('header', __('messages.metrics_history'))

@section('content')
    @include('components.tabs')

    <div id="historyMetrics" class="tab-content">
        <div id="historyMetricsContent" class="mt-6 flex justify-center">
            <table id="metricsTable" class="min-w-full bg-white shadow-md rounded-lg">
                <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="py-3 px-4 text-center">{{ __('messages.url') }}</th>
                    <th class="py-3 px-4 text-center">{{ __('messages.strategy') }}</th>
                    <th class="py-3 px-4 text-center">{{ __('messages.accessibility') }}</th>
                    <th class="py-3 px-4 text-center">{{ __('messages.pwa') }}</th>
                    <th class="py-3 px-4 text-center">{{ __('messages.performance') }}</th>
                    <th class="py-3 px-4 text-center">{{ __('messages.seo') }}</th>
                    <th class="py-3 px-4 text-center">{{ __('messages.best_practices') }}</th>
                    <th class="py-3 px-4 text-center">{{ __('messages.date_created') }}</th>
                </tr>
                </thead>
                <tbody id="metricsTableBody">
                </tbody>
            </table>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    @vite(['resources/css/custom-datatables.css', 'resources/js/datatables-init.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
@endsection
