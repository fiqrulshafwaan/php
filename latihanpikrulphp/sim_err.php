<?php
// Simulasikan POST jika koneksi database gagal
$dbMessage = "Koneksi database gagal: No connection could be made because the target machine actively refused it.<br><small>Pastikan MySQL di XAMPP Control Panel sudah dijalankan (Start) dan database '<strong>datapikrul</strong>' sudah ada.</small>";
echo "Panjang alert error: " . strlen($dbMessage) . "\n";
