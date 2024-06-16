@props(['title', 'score'])

<div class="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $title }}</h2>
    <p class="text-4xl font-bold text-indigo-600">{{ $score }}</p>
</div>
