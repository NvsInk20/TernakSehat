<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Flowbite CSS -->
    @vite('resources/css/app.css')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link rel="icon" href="/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 min-h-full flex">
    <!-- Sidebar -->
    @include('components.sidebar_pakar')
    <!-- Main Content -->
    @if (session('success') || session('error'))
        <div class="absolute top-10 left-1/2 ml-28 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-4 w-[90%] sm:w-[400px] flex items-center space-x-4 z-50 transition-opacity duration-300"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            @if (session('success'))
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-green-600 text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="text-red-600 text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <button @click="show = false" class="text-gray-500 hover:text-gray-700 ml-auto focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
    <div class="flex-1 bg-white p-6 mb-40">
        @include('components.dropSettings')
        <div class="p-8 bg-gray-50 max-h-screen">
            <div class="mt-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>
                <p class="text-gray-600">Silahkan kelola data dengan baik dan bijaksana</p>
                <div class="mt-4  w-3/4">
                    <!-- Grafik Chart.js -->
                    <canvas id="diagnosaChart" style="width: 300px; height: 150px;"
                        class="rounded-lg shadow-md"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const ctx = document.getElementById('diagnosaChart').getContext('2d');
            try {
                const response = await fetch('/chart-data');
                const data = await response.json();

                // Calculate the total number from the data
                const totalJumlah = data.data.reduce((acc, curr) => acc + curr, 0);

                // Get the most diagnosed disease
                const mostDiagnosedDisease = data.mostDiagnosedDisease;

                // Buat gradien untuk background bar
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(255, 165, 0, 0.7)'); // Oranye terang
                gradient.addColorStop(1, 'rgba(255, 165, 0, 0)'); // Transparan

                new Chart(ctx, {
                    type: 'bar', // Grafik batang
                    data: {
                        labels: data.labels, // Label penyakit
                        datasets: [{
                            label: 'Jumlah Diagnosa',
                            data: data.data, // Data jumlah diagnosa
                            backgroundColor: gradient, // Gradien warna untuk batang
                            borderColor: 'rgba(255, 140, 0, 1)', // Oranye gelap
                            borderWidth: 1, // Lebar border
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true, // Tampilkan legenda
                                labels: {
                                    color: '#333',
                                    font: {
                                        family: 'Poppins',
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true, // Tampilkan tooltip
                                callbacks: {
                                    label: function(context) {
                                        return `Jumlah: ${context.raw}`;
                                    }
                                }
                            },
                            datalabels: {
                                display: false,
                            },
                            // Update title to show most diagnosed disease
                            title: {
                                display: true,
                                text: `Penyakit Terbanyak: ${mostDiagnosedDisease}`, // Display the most diagnosed disease above the chart
                                font: {
                                    family: 'Poppins',
                                    size: 16,
                                    weight: 'bold'
                                },
                                padding: 10
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false // Hilangkan garis pada sumbu X
                                },
                                ticks: {
                                    color: '#666', // Warna teks sumbu X
                                    font: {
                                        family: 'Poppins',
                                        size: 12
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#eaeaea', // Warna garis grid
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    color: '#666', // Warna teks sumbu Y
                                    font: {
                                        family: 'Poppins',
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error fetching chart data:', error);
            }
        });
    </script>
</body>

</html>
