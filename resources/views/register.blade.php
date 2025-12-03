<!DOCTYPE html>
<html>
<head>
<title>Register</title>
</head>
<body>
<h2>Register</h2>
@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif
@if(session('error'))
<p style="color:red">{{ session('error') }}</p>
@endif
@if($errors->any())
<div style="color:red">
    @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif
<form method="POST" action="{{ route('register.post') }}">
@csrf
<input type="text" name="username" placeholder="Username" required><br>
<input type="text" name="nama" placeholder="Nama Lengkap" required><br>
<input type="password" name="password" placeholder="Password (minimal 8 karakter)" required><br>

<p>Pilih Role:</p>
<label><input type="radio" name="role" value="admin" required>Admin</label><br>
<label><input type="radio" name="role" value="guru">Guru</label><br>
<label><input type="radio" name="role" value="siswa">Siswa</label><br>

<!-- Form tambahan untuk Guru -->
<div id="guru-fields" style="display:none; margin-top:10px;">
    <input type="text" name="mapel" placeholder="Mata Pelajaran (contoh: Matematika)"><br>
</div>

<!-- Form tambahan untuk Siswa -->
<div id="siswa-fields" style="display:none; margin-top:10px;">
    <input type="number" name="tb" placeholder="Tinggi Badan (TB) dalam cm" min="30" max="250"><br>
    <input type="number" name="bb" placeholder="Berat Badan (BB) dalam kg" min="10" max="200"><br>
</div>

<button type="submit">Register</button>

<script>
    const siswaRadio = document.querySelector('input[name="role"][value="siswa"]');
    const guruRadio = document.querySelector('input[name="role"][value="guru"]');
    const adminRadio = document.querySelector('input[name="role"][value="admin"]');
    const siswaFields = document.getElementById('siswa-fields');
    const guruFields = document.getElementById('guru-fields');

    document.querySelectorAll('input[name="role"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Hide all fields first
            siswaFields.style.display = 'none';
            guruFields.style.display = 'none';
            
            // Show relevant fields
            if (siswaRadio.checked) {
                siswaFields.style.display = '';
            } else if (guruRadio.checked) {
                guruFields.style.display = '';
            }
        });
    });
</script>
</form>
<p><a href="{{ route('login') }}">Sudah punya akun? Login disini</a></p>
</body>
</html>
