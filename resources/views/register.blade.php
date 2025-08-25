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
<div id="siswa-fields" style="display:none;">
    <input type="number" name="bb" placeholder="Berat Badan (BB)" min="0"><br>
    <input type="number" name="tb" placeholder="Tinggi Badan (TB)" min="0"><br>
</div>
<p>Pilih Role:</p>
<label><input type="radio" name="role" value="admin" required>Admin</label><br>
<label><input type="radio" name="role" value="guru">Guru</label><br>
<label><input type="radio" name="role" value="siswa">Siswa</label><br>
<button type="submit">Register</button>
<script>
    const siswaRadio = document.querySelector('input[name="role"][value="siswa"]');
    const adminRadio = document.querySelector('input[name="role"][value="admin"]');
    const guruRadio = document.querySelector('input[name="role"][value="guru"]');
    const siswaFields = document.getElementById('siswa-fields');
    document.querySelectorAll('input[name="role"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (siswaRadio.checked) {
                siswaFields.style.display = '';
            } else {
                siswaFields.style.display = 'none';
            }
        });
    });
</script>
</form>
<p><a href="{{ route('login') }}">Sudah punya akun? Login disini</a></p>
</body>
</html>
