<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Kelas Saya</title>
    <style>
        .filter-container {
            margin: 20px 0;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 5px;
        }
        .filter-container label {
            margin-right: 10px;
            font-weight: bold;
        }
        .filter-container input, .filter-container select {
            padding: 5px 10px;
            margin-right: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #FF9800;
            color: white;
        }
        #loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            z-index: 9999;
        }
        #loading-overlay.hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div id="loading-overlay">Memuat data, mohon tunggu...</div>
    <div>
        <h2>Jadwal Kelas Saya</h2>
        <div>
            <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
            @if($siswa->kelas && $siswa->kelas->first())
                <p><strong>Kelas:</strong> {{ $siswa->kelas->first()->walas->jenjang }} {{ $siswa->kelas->first()->walas->namakelas }}</p>
                <p><strong>Wali Kelas:</strong> {{ $siswa->kelas->first()->walas->guru->nama ?? '-' }}</p>
            @else
                <p>Belum terdaftar di kelas manapun</p>
            @endif
        </div>
        
        <!-- Filter and Search -->
        <div class="filter-container">
            <label>Cari:</label>
            <input type="text" id="search" placeholder="Cari guru atau mapel...">
            
            <label>Filter Hari:</label>
            <select id="filter-hari">
                <option value="all">Semua Hari</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
            </select>
        </div>
        
        <!-- KBM Table -->
        <table id="tabel-kbm" border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Guru</th>
                    <th>Mata Pelajaran</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">Memuat data...</td>
                </tr>
            </tbody>
        </table>
        
        <br>
        <a href="{{ route('home') }}"><button>Kembali ke Home</button></a>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        let loadingTimeout = setTimeout(function() {
            $('#loading-overlay').addClass('hidden');
        }, 3000);

        function hideLoading() {
            $('#loading-overlay').addClass('hidden');
            clearTimeout(loadingTimeout);
        }

        function renderTable(data) {
            let rows = '';
            if (data.length === 0) {
                rows = '<tr><td colspan="6">Tidak ada jadwal ditemukan</td></tr>';
            } else {
                data.forEach((jadwal, index) => {
                    rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${jadwal.guru.nama}</td>
                        <td>${jadwal.guru.mapel}</td>
                        <td>${jadwal.hari}</td>
                        <td>${jadwal.mulai}</td>
                        <td>${jadwal.selesai}</td>
                    </tr>`;
                });
            }
            $('#tabel-kbm tbody').html(rows);
        }

        function loadKBM() {
            $.ajax({
                url: "{{ route('kbm.data') }}",
                method: "GET",
                success: function(response) {
                    renderTable(response);
                    hideLoading();
                },
                error: function() {
                    $('#tabel-kbm tbody').html('<tr><td colspan="6">Gagal memuat data jadwal.</td></tr>');
                    hideLoading();
                }
            });
        }

        function searchKBM(keyword, hari) {
            $.ajax({
                url: "{{ route('kbm.search') }}",
                method: "GET",
                data: { 
                    q: keyword,
                    hari: hari
                },
                success: function(response) {
                    renderTable(response);
                },
                error: function() {
                    console.error('Gagal mencari data jadwal.');
                }
            });
        }

        // Initial load
        loadKBM();

        // Search functionality with debounce
        let searchTimer;
        $('#search').on('keyup', function() {
            clearTimeout(searchTimer);
            const keyword = $(this).val().trim();
            const hari = $('#filter-hari').val();
            
            searchTimer = setTimeout(() => {
                if (keyword.length > 0 || hari !== 'all') {
                    searchKBM(keyword, hari);
                } else {
                    loadKBM();
                }
            }, 300);
        });

        // Filter by day
        $('#filter-hari').on('change', function() {
            const keyword = $('#search').val().trim();
            const hari = $(this).val();
            
            if (keyword.length > 0 || hari !== 'all') {
                searchKBM(keyword, hari);
            } else {
                loadKBM();
            }
        });
    });
    </script>
</body>
</html>
