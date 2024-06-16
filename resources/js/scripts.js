import Swal from 'sweetalert2';
import { __, setLanguage } from './translation';

document.addEventListener('DOMContentLoaded', () => {
    const selectedLanguage = document.documentElement.lang; // Get the language from the HTML tag
    setLanguage(selectedLanguage);

    const fetchButton = document.getElementById('fetchMetrics');
    const saveMetricsButton = document.getElementById('saveMetrics');

    fetchButton.addEventListener('click', fetchMetrics);
    saveMetricsButton.addEventListener('click', () => saveMetrics(currentData));
});


let currentData = null;

async function fetchMetrics() {
    if (!validateForm()) {
        return;
    }

    const fetchButton = document.getElementById('fetchMetrics');
    const urlInput = document.getElementById('url');
    const strategySelect = document.getElementById('strategy');
    const categories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked')).map(el => el.value);

    const url = formatUrl(urlInput.value);
    const params = createParams(url, strategySelect.value, categories);

    toggleLoadingState(fetchButton, true);

    try {
        const response = await fetch(`/metrics/fetch?${params}`, {
            headers: {
                'X-CSRF-TOKEN': getCsrfToken()
            }
        });

        if (!response.ok) {
            const errorData = await response.json();
            handleErrors(errorData.errors);
            throw new Error(__('fetch_metrics_error'));
        }

        currentData = await response.json();
        renderMetrics(currentData);
        toggleElementVisibility(document.getElementById('saveMetrics'), true);
    } catch (error) {
        console.error(__('fetch_metrics_error'), error);
        showErrorMessages({ general: [__('general_error')] });
    } finally {
        toggleLoadingState(fetchButton, false);
    }
}

function formatUrl(url) {
    if (!url.startsWith('http://') && !url.startsWith('https://')) {
        return 'http://' + url;
    }
    return url;
}

function createParams(url, strategy, categories) {
    const params = new URLSearchParams({ url, strategy_id: strategy });
    categories.forEach(category => params.append('categories[]', category));
    return params.toString();
}

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

function toggleLoadingState(button, isLoading) {
    button.disabled = isLoading;
    button.innerHTML = isLoading ? `${__('fetching')}... <span class="loading-icon"></span>` : __('fetch_metrics');
    button.classList.toggle('loading', isLoading);
}

function toggleElementVisibility(element, isVisible) {
    element.classList.toggle('hidden', !isVisible);
}

function renderMetrics(data) {
    const container = document.getElementById('metricsCards');
    container.innerHTML = '';

    Object.values(data.categories).forEach((cat, index) => {
        if (cat.score !== null) {
            const card = createMetricCard(cat.title, cat.score, index);
            container.appendChild(card);
        }
    });
}

function createMetricCard(title, score, index) {
    const card = document.createElement('div');
    card.className = 'bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 fade-in-down';
    card.style.animationDelay = `${index * 0.1}s`;

    const scorePercentage = Math.round(score * 100);

    card.innerHTML = `
        <h2 class="text-xl font-semibold text-gray-800 mb-2">${title}</h2>
        <div class="relative">
            <canvas id="chart-${index}" width="100" height="100"></canvas>
            <div id="score-${index}" class="absolute inset-0 flex items-center justify-center text-indigo-600 text-2xl font-semibold">0%</div>
        </div>
    `;

    setTimeout(() => {
        drawChart(index, scorePercentage);
        animateScore(`score-${index}`, scorePercentage);
    }, index * 100);

    return card;
}

async function saveMetrics(data) {
    const payload = createPayload(data);

    try {
        const response = await fetch('/metrics/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify(payload)
        });

        if (response.ok) {
            showSuccessMessage(__('metrics_save_success'));
        } else {
            const errorData = await response.json();
            handleErrors(errorData.errors);
        }
    } catch (error) {
        console.error(__('metrics_save_error'), error);
        showErrorMessages({ general: [__('metrics_save_error')] });
    }
}

function createPayload(data) {
    return {
        url: data.id,
        strategy_id: data.strategy === 'DESKTOP' ? 1 : 2,
        accessibility_metric: data.categories.ACCESSIBILITY?.score ?? null,
        pwa_metric: data.categories.PWA?.score ?? null,
        performance_metric: data.categories.PERFORMANCE?.score ?? null,
        seo_metric: data.categories.SEO?.score ?? null,
        best_practices_metric: data.categories.BEST_PRACTICES?.score ?? null,
    };
}

function handleErrors(errors) {
    if (errors) {
        showErrorMessages(errors);
    } else {
        showErrorMessages({ general: [__('general_error')] });
    }
}

function showErrorMessages(errors) {
    let errorMessages = '';
    for (const key in errors) {
        if (errors.hasOwnProperty(key)) {
            errorMessages += `${errors[key].join(' ')}<br>`;
        }
    }
    Swal.fire({
        icon: 'error',
        title: __('validation_error'),
        html: errorMessages,
    });
}

function showSuccessMessage(message) {
    Swal.fire({
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
    });
}

function drawChart(index, scorePercentage) {
    const ctx = document.getElementById(`chart-${index}`).getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [scorePercentage, 100 - scorePercentage],
                backgroundColor: ['#4f46e5', '#e5e7eb'],
                borderWidth: 2,
                borderColor: 'transparent'
            }]
        },
        options: {
            cutout: '80%',
            plugins: {
                tooltip: { enabled: false },
                legend: { display: false }
            }
        }
    });
}

function animateScore(elementId, scorePercentage) {
    const element = document.getElementById(elementId);
    let start = 0;
    const end = scorePercentage;
    const duration = 1000;
    const stepTime = Math.abs(Math.floor(duration / end));

    function step() {
        start++;
        element.textContent = `${start}%`;
        if (start < end) {
            setTimeout(step, stepTime);
        }
    }

    step();
}

function validateForm() {
    const urlInput = document.getElementById('url');
    const strategySelect = document.getElementById('strategy');
    const categories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked'));

    let isValid = true;
    let errorMessages = [];

    if (!urlInput.value) {
        isValid = false;
        errorMessages.push(__('url_required'));
    }

    if (strategySelect.value === "") {
        isValid = false;
        errorMessages.push(__('strategy_required'));
    }

    if (categories.length === 0) {
        isValid = false;
        errorMessages.push(__('category_required'));
    }

    if (!isValid) {
        showErrorMessages({ general: errorMessages });
    }

    return isValid;
}
