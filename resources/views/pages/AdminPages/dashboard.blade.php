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
    @include('components.sidebar_admin')
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

    <!-- Main Content -->
    <div class="flex-1 bg-white p-6 mb-40">
        @include('components.dropSettings')
        <div class="p-8 bg-gray-50 max-h-screen">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>
            <div class="grid grid-cols-3 gap-6 w-9/12">
                <!-- Tampilkan Data -->
                @php
                    $jumlahPengguna = DB::table('akun_pengguna')->where('role', 'user')->count(); // Query langsung dari database
                    $jumlahPakar = DB::table('akun_pengguna')->where('role', 'ahli pakar')->count();
                    $jumlahPenyakit = DB::table('penyakit')->count();
                @endphp

                <!-- Card User -->
                <div
                    class="flex items-center justify-between p-6 bg-orange-100 border-l-4 border-orange-500 rounded-lg shadow-sm">
                    <div>
                        <div class="text-xl font-bold text-gray-800">{{ $jumlahPengguna ?? 0 }}</div>
                        <div class="text-sm font-medium text-gray-600">User (Peternak)</div>
                    </div>
                    <div class="text-orange-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <!-- Card Ahli Pakar -->
                <div
                    class="flex items-center justify-between p-6 bg-green-100 border-l-4 border-green-500 rounded-lg shadow-sm">
                    <div>
                        <div class="text-xl font-bold text-gray-800">{{ $jumlahPakar ?? 0 }}</div>
                        <div class="text-sm font-medium text-gray-600">Ahli Pakar</div>
                    </div>
                    <div class="text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <!-- Card Penyakit -->
                <div
                    class="flex items-center justify-between p-6 bg-teal-100 border-l-4 border-teal-500 rounded-lg shadow-sm">
                    <div>
                        <div class="text-xl font-bold text-gray-800">{{ $jumlahPenyakit ?? 0 }}</div>
                        <div class="text-sm font-medium text-gray-600">Data Penyakit</div>
                    </div>
                    <div class="text-teal-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-800">Manajemen Sistem</h2>
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
