<!DOCTYPE html>
<html lang="en"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      x-init="$watch('dark', val => {
        document.documentElement.classList.toggle('dark', val);
        localStorage.setItem('theme', val ? 'dark' : 'light');
      })"
      :class="{ 'dark': dark }">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Finance Reports' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <style>
        :root {
            --bg: #f9fafb;
            --card-bg: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
            --shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
        }

        .dark {
            --bg: #0f172a;
            --card-bg: #1e293b;
            --text: #f1f5f9;
            --muted: #9ca3af;
            --border: #334155;
            --shadow: 0 4px 14px rgba(255, 255, 255, 0.05);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            transition: background 0.3s ease, color 0.3s ease;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 1rem;
        }

        .theme-toggle {
            text-align: right;
            margin-bottom: 1rem;
        }

        .theme-toggle button {
            background-color: var(--card-bg);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 0.1rem 0.8rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle button:hover {
            box-shadow: var(--shadow);
        }

        h2 {
            text-align: center;
            margin-bottom: 2rem;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            border-radius: 12px;
            padding: 1rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .summary-card p {
            font-size: 0.85rem;
            margin: 0;
            opacity: 0.85;
        }

        .summary-card h4 {
            font-size: 1.5rem;
            margin: 0.25rem 0 0 0;
        }

        .bg-payments { background-color: #10b981; }
        .bg-expenses { background-color: #ef4444; }
        .bg-budgets { background-color: #3b82f6; }
        .bg-invoices { background-color: #f59e0b; }

        .chart-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .chart-container {
            background-color: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem;
            box-shadow: var(--shadow);
            transition: background 0.3s ease;
        }

        .chart-container h3 {
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="theme-toggle">
        <button @click="dark = !dark" aria-label="Toggle Theme">
            <span x-show="!dark">🌞 Light Mode</span>
            <span x-show="dark">🌙 Dark Mode</span>
        </button>
    </div>

    <div class="summary">
        @foreach ($summary as $item)
            <div class="summary-card {{ $item['class'] }}">
                <p>{{ $item['label'] }}</p>
                <h4>ZMW {{ number_format($item['value'], 2) }}</h4>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="shadow rounded p-4 chart-container">
            <h3 class="text-sm font-semibold mb-2">Payments by Method</h3>
            <ul>
                @foreach($paymentsByMethod as $method => $amount)
                    <li class="text-sm">{{ ucfirst($method) }}: ZMW {{ number_format($amount, 2) }}</li>
                @endforeach
            </ul>
        </div>
        <div class="shadow rounded p-4 chart-container">
            <h3 class="text-sm font-semibold mb-2">Expenses by Category</h3>
            <ul>
                @foreach($expensesByCategory as $category => $amount)
                    <li class="text-sm">{{ ucfirst($category) }}: ZMW {{ number_format($amount, 2) }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="chart-grid">
        <div class="chart-container">
            <h3>Summary Bar</h3>
            <canvas id="summaryChart" aria-label="Summary bar chart" role="img"></canvas>
        </div>
        <div class="chart-container">
            <h3>Distribution</h3>
            <canvas id="distributionChart" aria-label="Distribution doughnut chart" role="img"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const financeData = @json($financeData);

        const dataArray = [
            financeData.payments || 0,
            financeData.invoices || 0,
            financeData.expenses || 0,
            financeData.budgets || 0
        ];

        const labels = ['Payments', 'Invoices', 'Expenses', 'Budgets'];
        const colors = ['#10b981', '#f59e0b', '#ef4444', '#3b82f6'];

        new Chart(document.getElementById('summaryChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'ZMW',
                    data: dataArray,
                    backgroundColor: colors,
                    borderRadius: 8,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => `ZMW ${ctx.parsed.y.toLocaleString()}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: getComputedStyle(document.body).getPropertyValue('--muted')
                        }
                    },
                    x: {
                        ticks: {
                            color: getComputedStyle(document.body).getPropertyValue('--muted')
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('distributionChart'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: dataArray,
                    backgroundColor: colors,
                    hoverOffset: 12
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: getComputedStyle(document.body).getPropertyValue('--muted')
                        }
                    }
                }
            }
        });
    });
</script>
</body>
</html>
