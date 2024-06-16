@extends('layouts.app')

@section('title', __('messages.current_metrics'))

@section('header', __('messages.current_metrics'))

@section('content')
    @include('components.tabs')

    <div id="currentMetrics" class="tab-content">
        @include('components.metrics-form')

        <div id="metricsCards" class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Metrics cards will be appended here -->
        </div>
        <div class="flex justify-end mt-4">
            <button type="button" id="saveMetrics" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 hidden">{{ __('messages.save_metrics') }}</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/scripts.js'])
    <style>
    </style>
@endsection
