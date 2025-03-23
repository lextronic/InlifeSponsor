@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- konten utama -->
<div class="main-content">
    <!-- Diagram -->
    <div class="container-grafik" style="border-style: none;">
        <strong style="text-align: center;">Grafik Jumlah Pengajuan Sponsorship Telkomsel Branch Surabaya</strong><br>
        <strong style="text-align: center;">2024 - 2025</strong>
        <div class="breadcrumb">
            <a id="breadcrumbRoot" href="javascript:void(0)">Ajuan</a>
            <span id="breadcrumbYear"></span>
            <span id="breadcrumbMonth"></span>
        </div>
        <div style="width: 100%; margin:auto;" id="mainContainer">
            <canvas id="chartContainer"></canvas>
        </div>
    </div>
</div>
<!-- chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartContainer').getContext('2d');
    let chart, currentLevel = 'year',
        isDrilldown = false,
        currentYear = null,
        currentMonth = null;

    // Fungsi untuk fetch data tahunan
    function fetchYearlyData() {
        currentLevel = 'year';
        fetch('/admin/dashboard/chart/yearly-data')
            .then(response => response.json())
            .then(yearlyData => {
                const labels = Object.keys(yearlyData);
                const data = Object.values(yearlyData);
                renderChart(labels, data, 'Jumlah Ajuan per Tahun', 'Tahun', 'Jumlah Ajuan');
            })
            .catch(error => console.error('Error fetching yearly data:', error));
    }

    // Fungsi untuk fetch data bulanan
    function fetchMonthlyData(year) {
        currentLevel = 'month';
        currentYear = year;
        fetch(`/admin/dashboard/chart/monthly-data/${year}`)
            .then(response => response.json())
            .then(monthlyData => {
                const labels = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei',
                    'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                    'November', 'Desember'
                ];
                const data = labels.map((_, index) => monthlyData[index + 1] || 0);

                renderChart(labels, data, `Jumlah Ajuan di Tahun ${year}`, 'Bulan', 'Jumlah Ajuan', year);

                updateBreadcrumb();
            })
            .catch(error => console.error('Error fetching monthly data:', error));
    }

    // Fungsi untuk fetch data status
    function fetchStatusData(year, month, monthName) {
        currentLevel = 'status';
        currentMonth = month;
        fetch(`/admin/dashboard/chart/status-data/${year}/${month}`)
            .then(response => response.json())
            .then(statusData => {
                const labels = ['Menunggu', 'Ditolak', 'Aktif'];
                const data = [
                    statusData.menunggu || 0,
                    statusData.ditolak || 0,
                    statusData.aktif || 0
                ];
                showDrilldownChart(labels, data, monthName);
                updateBreadcrumb();
            })
            .catch(error => console.error('Error fetching status data:', error));
    }

    // Fungsi untuk render chart utama
    function renderChart(labels, data, title, xLabel, yLabel, year = null, month = null, monthName = null) {
        if (chart) chart.destroy(); // Hapus chart sebelumnya
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Ajuan',
                    backgroundColor: ['rgba(255, 99, 132, 0.5)', // Warna batang Januari
                        'rgba(54, 162, 235, 0.5)', // Warna batang Februari
                        'rgba(255, 206, 86, 0.5)', // Warna batang Maret
                        'rgba(75, 192, 192, 0.5)', // Warna batang April
                        'rgba(153, 102, 255, 0.5)', // Warna batang Mei
                        'rgba(255, 159, 64, 0.5)', // Warna batang Juni
                        'rgba(99, 255, 132, 0.5)', // Warna batang Juli
                        'rgba(132, 255, 225, 0.5)', // Warna batang Agustus
                        'rgba(255, 99, 222, 0.5)', // Warna batang September
                        'rgba(164, 74, 255, 0.5)', // Warna batang Oktober
                        'rgba(235, 64, 52, 0.5)', // Warna batang November
                        'rgba(50, 99, 235, 0.5)'
                    ],
                    data: data
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: title
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: xLabel
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: yLabel
                        }
                    }
                },

                onClick: (e, elements) => {
                    if (elements.length === 0) return;
                    const index = elements[0].index + 1; // Bulan dimulai dari 1
                    if (currentLevel === 'year') {
                        fetchMonthlyData(labels[index - 1]); // Drilldown ke level bulan
                    } else if (currentLevel === 'month') {
                        const monthName = labels[index - 1];
                        fetchStatusData(year, index, monthName); // Drilldown ke level status
                    }
                }
            }
        });
    }

    // Fungsi untuk render chart drilldown
    function showDrilldownChart(labels, data, monthName) {
        isDrilldown = true;
        chart.data.labels = labels;
        chart.data.datasets[0].data = data;
        chart.data.datasets[0].backgroundColor = [
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 99, 132, 0.5)',
            'rgba(255, 206, 86, 0.5)'
        ];
        chart.options.plugins.title.text = `Detail Ajuan (${monthName})`;
        chart.options.scales.x.title.text = 'Status Ajuan';
        chart.options.scales.y.title.text = 'Jumlah Ajuan';
        chart.update();
    }

    // Fungsi untuk update breadcrumb
    function updateBreadcrumb() {
        const breadcrumbRoot = document.getElementById('breadcrumbRoot');
        const breadcrumbYear = document.getElementById('breadcrumbYear');
        const breadcrumbMonth = document.getElementById('breadcrumbMonth');

        // Reset breadcrumb
        breadcrumbYear.innerHTML = '';
        breadcrumbMonth.innerHTML = '';

        // Root level (Ajuan)
        breadcrumbRoot.setAttribute('href', '#');

        // Tambahkan tahun ke breadcrumb jika ada
        if (currentYear) {
            breadcrumbYear.innerHTML = ` / <a href="#" id="breadcrumbYearLink">${currentYear}</a>`;

        }

        // Tambahkan bulan ke breadcrumb jika ada
        if (currentMonth) {
            const monthName = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei',
                'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                'November', 'Desember'
            ][currentMonth - 1];
            breadcrumbMonth.innerHTML = ` / <a id="breadcrumbMonthLink">${monthName}</a>`;
        }
    }

    // Fungsi untuk reset chart ke data utama
    function resetChart() {
        isDrilldown = false;
        currentYear = null;
        currentMonth = null;
        updateBreadcrumb(); // Reset breadcrumb ke level root
        fetchYearlyData();
    }

    // Event listener untuk breadcrumb
    document.getElementById('breadcrumbRoot').addEventListener('click', () => {
        resetChart();
    });

    document.addEventListener('click', (e) => {
        if (e.target.id === 'breadcrumbYearLink') {
            currentMonth = null;
            fetchMonthlyData(currentYear); // Kembali ke data bulanan
            updateBreadcrumb();
        } else if (e.target.id === 'breadcrumbMonthLink') {
            fetchStatusData(currentYear, currentMonth); // Kembali ke data status
        }
    });

    // Inisialisasi fetch data utama saat halaman dimuat
    fetchYearlyData();
</script>
@endsection