<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Mengajar Saya</title>
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
        .filter-container select {
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
            background-color: #2196F3;
            color: white;
        }
    </style>
</head>
<body>
    <div>
        <h2>Jadwal Mengajar Saya</h2>
        <div>
            <p><strong>Nama:</strong> {{ $guru->nama }}</p>
            <p><strong>Mata Pelajaran:</strong> {{ $guru->mapel }}</p>
            <p><strong>Role:</strong> Guru</p>
        </div>
        
        <!-- Filter -->
        <div class="filter-container">
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
                    <th>Kelas</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5">Memuat data...</td>
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
        function renderTable(data) {
            let rows = '';
            if (data.length === 0) {
                rows = '<tr><td colspan="5">Tidak ada jadwal ditemukan</td></tr>';
            } else {
                data.forEach((jadwal, index) => {
                    rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${jadwal.walas.jenjang} ${jadwal.walas.namakelas}</td>
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
                },
                error: function() {
                    $('#tabel-kbm tbody').html('<tr><td colspan="5">Gagal memuat data jadwal.</td></tr>');
                }
            });
        }

        function filterKBM(hari) {
            $.ajax({
                url: "{{ route('kbm.search') }}",
                method: "GET",
                data: { hari: hari },
                success: function(response) {
                    renderTable(response);
                },
                error: function() {
                    console.error('Gagal memfilter data jadwal.');
                }
            });
        }

        // Initial load
        loadKBM();

        // Filter by day
        $('#filter-hari').on('change', function() {
            const hari = $(this).val();
            
            if (hari !== 'all') {
                filterKBM(hari);
            } else {
                loadKBM();
            }
        });
    });
    </script>
</body>
</html>
