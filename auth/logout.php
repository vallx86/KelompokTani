<?php
// auth/logout.php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Redirect ke halaman login dengan pesan
echo "<script>
    alert('Anda telah berhasil logout. Terima kasih telah menggunakan PetaniGenZ!');
    window.location.href = 'login.html';
</script>";
exit;
?>