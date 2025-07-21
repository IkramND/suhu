<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desain Tema Gelap/Terang - Dasbor Monitoring</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Menggunakan font Inter sebagai default */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Styling dasar untuk light mode */
        :root {
            --bg-primary: #f8fafc; /* Latar belakang utama */
            --bg-secondary: #ffffff; /* Latar belakang elemen seperti kartu, sidebar */
            --text-primary: #1e293b; /* Warna teks utama */
            --text-secondary: #64748b; /* Warna teks sekunder/abu-abu */
            --border-color: #e2e8f0; /* Warna border */
            --accent-color: #3b82f6; /* Warna aksen untuk tombol, link aktif */
            --sidebar-bg: #1e293b;
            --sidebar-text: #e2e8f0;
            --sidebar-active-bg: #334155;
        }

        /* Styling untuk dark mode */
        .dark {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --border-color: #334155;
            --accent-color: #60a5fa;
            --sidebar-bg: #0f172a;
            --sidebar-text: #e2e8f0;
            --sidebar-active-bg: #334155;
        }

        /* Transisi warna yang mulus */
        body, .sidebar, .card, input, button {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Style untuk toggle switch */
        .theme-switch-wrapper {
            display: flex;
            align-items: center;
        }
        .theme-switch {
            display: inline-block;
            height: 24px;
            position: relative;
            width: 44px;
        }
        .theme-switch input {
            display:none;
        }
        .slider {
            background-color: #ccc;
            bottom: 0;
            cursor: pointer;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            transition: .4s;
        }
        .slider:before {
            background-color: #fff;
            bottom: 4px;
            content: "";
            height: 16px;
            left: 4px;
            position: absolute;
            transition: .4s;
            width: 16px;
        }
        input:checked + .slider {
            background-color: var(--accent-color);
        }
        input:checked + .slider:before {
            transform: translateX(20px);
        }
        .slider.round {
            border-radius: 34px;
        }
        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>
<body class="bg-[var(--bg-primary)] text-[var(--text-primary)]">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="sidebar w-64 bg-[var(--sidebar-bg)] text-[var(--sidebar-text)] p-4 flex flex-col">
            <h1 class="text-xl font-bold mb-8 text-white">Monitoring Server</h1>
            <nav class="flex flex-col space-y-2">
                <a href="#" class="px-4 py-2 rounded-md font-semibold bg-[var(--sidebar-active-bg)] text-white">Dashboard</a>
                <a href="#" class="px-4 py-2 rounded-md hover:bg-[var(--sidebar-active-bg)]">Settings</a>
                <a href="#" class="px-4 py-2 rounded-md hover:bg-[var(--sidebar-active-bg)]">Add Tools</a>
                <a href="#" class="px-4 py-2 rounded-md hover:bg-[var(--sidebar-active-bg)]">Tools List</a>
                <a href="#" class="px-4 py-2 rounded-md hover:bg-[var(--sidebar-active-bg)]">Machine Limit Sensor</a>
                <a href="#" class="px-4 py-2 rounded-md hover:bg-[var(--sidebar-active-bg)]">Email Configuration</a>
                <a href="#" class="px-4 py-2 rounded-md hover:bg-[var(--sidebar-active-bg)]">Calibration</a>
            </nav>
            <div class="mt-auto">
                 <div class="flex items-center justify-between p-2 rounded-md bg-[var(--bg-secondary)]">
                    <span class="text-sm font-medium text-[var(--text-primary)]">Ganti Tema</span>
                    <div class="theme-switch-wrapper">
                        <label class="theme-switch" for="theme-toggle">
                            <input type="checkbox" id="theme-toggle" />
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            <header class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-[var(--text-primary)]">Monitoring Suhu Ruang Server</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-[var(--text-secondary)]">Guest</span>
                    <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                </div>
            </header>

            <!-- Info Cards -->
            <div class="card bg-[var(--bg-secondary)] p-6 rounded-lg border border-[var(--border-color)]">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" style="">
                    <div>
                        <p class="text-sm text-[var(--text-secondary)]">Machine ID</p>
                        <p class="font-bold text-lg">ALAT001 (ROB2)</p>
                    </div>
                    <div>
                        <p class="text-sm text-[var(--text-secondary)]">Status</p>
                        <p class="font-bold text-lg text-red-500">Inactive</p>
                    </div>
                    <div>
                        <p class="text-sm text-[var(--text-secondary)]">IP</p>
                        <p class="font-bold text-lg">192.168.0.200</p>
                    </div>
                    <div>
                        <p class="text-sm text-[var(--text-secondary)]">Last update</p>
                        <p class="font-bold text-lg">14:05</p>
                    </div>
                    <div class="flex items-end space-x-2">
                        <div class="flex-1">
                            <label for="range-data" class="text-sm text-[var(--text-secondary)]">Range data</label>
                            <input type="text" id="range-data" value="MAX 18" class="w-full mt-1 p-2 rounded-md bg-[var(--bg-primary)] border border-[var(--border-color)]">
                        </div>
                        <button class="px-4 py-2 bg-[var(--accent-color)] text-white rounded-md font-semibold hover:opacity-90">Update</button>
                    </div>
                    <div class="flex items-end space-x-2">
                         <div class="flex-1">
                            <label for="duration-data" class="text-sm text-[var(--text-secondary)]">Duration data</label>
                            <input type="text" id="duration-data" value="Default 60 Second" class="w-full mt-1 p-2 rounded-md bg-[var(--bg-primary)] border border-[var(--border-color)]">
                        </div>
                        <button class="px-4 py-2 bg-[var(--accent-color)] text-white rounded-md font-semibold hover:opacity-90">Update</button>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="card mt-6 bg-[var(--bg-secondary)] p-6 rounded-lg border border-[var(--border-color)]">
                <canvas id="monitoringChart"></canvas>
            </div>
        </main>
    </div>

    <script>
        // JavaScript untuk mengelola pergantian tema
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;

        // Cek tema yang tersimpan di localStorage (jika ada)
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark');
            themeToggle.checked = true;
        }

        // Event listener untuk toggle
        themeToggle.addEventListener('change', function() {
            if (this.checked) {
                body.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
            // Perlu update warna chart setelah ganti tema
            updateChartColors();
        });

        // Data dan konfigurasi untuk Chart.js
        const ctx = document.getElementById('monitoringChart').getContext('2d');
        const labels = ['17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00', '14:03', '14:04', '14:05'];
        const temperatureData = [27, 26, 25, 24, 23, 22, 21, 27.5, 27.5, 27.5];
        const humidityData = [55, 60, 65, 68, 70, 72, 75, 75, 74, 55];

        // Fungsi untuk mendapatkan warna berdasarkan tema
        function getChartColors() {
            const isDarkMode = body.classList.contains('dark');
            return {
                gridColor: isDarkMode ? 'rgba(148, 163, 184, 0.2)' : 'rgba(203, 213, 225, 0.5)',
                textColor: isDarkMode ? '#e2e8f0' : '#1e293b',
                tempColor: '#ef4444', // Red
                humidityColor: '#3b82f6' // Blue
            };
        }

        let monitoringChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Temperature (°C)',
                    data: temperatureData,
                    borderColor: getChartColors().tempColor,
                    backgroundColor: 'transparent',
                    tension: 0.1,
                    yAxisID: 'y'
                }, {
                    label: 'Humidity (%)',
                    data: humidityData,
                    borderColor: getChartColors().humidityColor,
                    backgroundColor: 'transparent',
                    tension: 0.1,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        ticks: { color: getChartColors().textColor },
                        grid: { color: getChartColors().gridColor }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Temperature (°C)',
                            color: getChartColors().tempColor
                        },
                        ticks: { color: getChartColors().tempColor },
                        grid: { drawOnChartArea: false } // Hanya grid utama
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Humidity (%)',
                            color: getChartColors().humidityColor
                        },
                        ticks: { color: getChartColors().humidityColor },
                        grid: { color: getChartColors().gridColor }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: getChartColors().textColor
                        }
                    }
                }
            }
        });

        // Fungsi untuk mengupdate warna chart saat tema berubah
        function updateChartColors() {
            const colors = getChartColors();
            monitoringChart.options.scales.x.ticks.color = colors.textColor;
            monitoringChart.options.scales.x.grid.color = colors.gridColor;
            monitoringChart.options.scales.y.title.color = colors.tempColor;
            monitoringChart.options.scales.y.ticks.color = colors.tempColor;
            monitoringChart.options.scales.y1.title.color = colors.humidityColor;
            monitoringChart.options.scales.y1.ticks.color = colors.humidityColor;
            monitoringChart.options.scales.y1.grid.color = colors.gridColor;
            monitoringChart.options.plugins.legend.labels.color = colors.textColor;
            monitoringChart.update();
        }

    </script>
</body>
</html>
