<?php
// Fungsi untuk menentukan apakah hari ini adalah akhir pekan (Sabtu atau Minggu)
function isWeekend($day) {
    return ($day == "Saturday" || $day == "Sunday");
}

// Fungsi untuk menghitung total harga tiket dan diskon (jika ada)
function calculateTotal($adultTickets, $childTickets, $day) {
    $adultPrice = 50000;  // Harga tiket dewasa
    $childPrice = 30000;  // Harga tiket anak-anak
    $weekendSurcharge = 10000; // Biaya tambahan untuk akhir pekan
    
    // Hitung total harga tiket dewasa dan anak-anak
    $totalAdultPrice = $adultTickets * $adultPrice;
    $totalChildPrice = $childTickets * $childPrice;
    
    // Jika hari pemesanan adalah akhir pekan, tambahkan biaya tambahan per tiket
    if (isWeekend($day)) {
        $totalAdultPrice += $adultTickets * $weekendSurcharge;
        $totalChildPrice += $childTickets * $weekendSurcharge;
    }
    
    // Hitung total harga keseluruhan sebelum diskon
    $totalBeforeDiscount = $totalAdultPrice + $totalChildPrice;

    // Inisialisasi variabel diskon
    $discount = 0;

    // Berikan diskon 10% jika total harga melebihi Rp150.000
    if ($totalBeforeDiscount > 150000) {
        $discount = 0.1 * $totalBeforeDiscount;
    }
    
    // Hitung total harga setelah diskon
    $totalPrice = $totalBeforeDiscount - $discount;
    
    return [
        'totalBeforeDiscount' => $totalBeforeDiscount,
        'totalPrice' => $totalPrice,
        'discount' => $discount,
        'adultPrice' => $adultPrice,
        'childPrice' => $childPrice,
        'isWeekend' => isWeekend($day), // Tambahkan status akhir pekan
    ];
}

// Simulasi input dari pengguna
$adultTickets = isset($_POST['adultTickets']) ? (int)$_POST['adultTickets'] : 0;
$childTickets = isset($_POST['childTickets']) ? (int)$_POST['childTickets'] : 0;
$day = isset($_POST['day']) ? $_POST['day'] : date('l');  // Hari pemesanan, default ke hari ini

// Hitung total harga dan diskon
$result = calculateTotal($adultTickets, $childTickets, $day);
$totalBeforeDiscount = $result['totalBeforeDiscount'];
$totalPrice = $result['totalPrice'];
$discount = $result['discount'];
$adultPrice = $result['adultPrice'];
$childPrice = $result['childPrice'];
$isWeekend = $result['isWeekend']; // Ambil status akhir pekan
$weekendSurchargeTotal = $isWeekend ? ($adultTickets + $childTickets) * 10000 : 0; // Hitung total biaya tambahan akhir pekan jika ada
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Dashboard Website" />
    <meta name="keywords" content="HTML,CSS, Javascript" />
    <meta name="author" content="M. Denny Tri Lisandi" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>Sistem Pemesanan Tiket Bioskop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Pemesanan Tiket Bioskop</h1>
        
        <form id="ticketForm" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="adultTickets" class="form-label">Jumlah Tiket Dewasa:</label>
                <input type="number" class="form-control" id="adultTickets" name="adultTickets" min="0" value="<?php echo $adultTickets; ?>">
            </div>
            
            <div class="mb-3">
                <label for="childTickets" class="form-label">Jumlah Tiket Anak-anak:</label>
                <input type="number" class="form-control" id="childTickets" name="childTickets" min="0" value="<?php echo $childTickets; ?>">
            </div>
            
            
            <div class="mb-3">
                <label for="day" class="form-label">Hari Pemesanan:</label>
                <select id="day" name="day" class="form-select">
                    <option value="Monday" <?php if ($day == "Monday") echo "selected"; ?>>Senin</option>
                    <option value="Tuesday" <?php if ($day == "Tuesday") echo "selected"; ?>>Selasa</option>
                    <option value="Wednesday" <?php if ($day == "Wednesday") echo "selected"; ?>>Rabu</option>
                    <option value="Thursday" <?php if ($day == "Thursday") echo "selected"; ?>>Kamis</option>
                    <option value="Friday" <?php if ($day == "Friday") echo "selected"; ?>>Jumat</option>
                    <option value="Saturday" <?php if ($day == "Saturday") echo "selected"; ?>>Sabtu</option>
                    <option value="Sunday" <?php if ($day == "Sunday") echo "selected"; ?>>Minggu</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="adultPrice" class="form-label">Harga Tiket Dewasa:</label>
                <input type="text" class="form-control" id="adultPrice" name="adultPrice" value="Rp<?php echo number_format($adultPrice, 0, ',', '.'); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="childPrice" class="form-label">Harga Tiket Anak-anak:</label>
                <input type="text" class="form-control" id="childPrice" name="childPrice" value="Rp<?php echo number_format($childPrice, 0, ',', '.'); ?>" readonly>
            </div>

            <!-- Tambahkan Input untuk Biaya Tambahan Akhir Pekan -->
            <?php if ($isWeekend): ?>
            <div class="mb-3">
                <label for="weekendSurcharge" class="form-label">Biaya Tambahan Akhir Pekan (total tiket dikali Rp10.000):</label>
                <input type="text" class="form-control" id="weekendSurcharge" name="weekendSurcharge" value="Rp<?php echo number_format($weekendSurchargeTotal, 0, ',', '.'); ?>" readonly>
            </div>
            <?php endif; ?>
            <br>
            <button type="submit" class="btn btn-primary">Hitung Total</button>
            <br>
            <br>
            <div class="mb-3">
                <label for="totalBeforeDiscount" class="form-label">Total Harga Sebelum Diskon:</label>
                <input type="text" class="form-control" id="totalBeforeDiscount" name="totalBeforeDiscount" value="Rp<?php echo number_format($totalBeforeDiscount, 0, ',', '.'); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="discount" class="form-label">Diskon 10% (jika melebihi Rp150.000):</label>
                <input type="text" class="form-control" id="discount" name="discount" value="<?php echo ($discount > 0) ? 'Rp' . number_format($discount, 0, ',', '.') : 'Tidak ada diskon'; ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="totalPrice" class="form-label">Total Harga:</label>
                <input type="text" class="form-control" id="totalPrice" name="totalPrice" value="Rp<?php echo number_format($totalPrice, 0, ',', '.'); ?>" readonly>
            </div>
            <button type="button" class="btn btn-success" onclick="showPopup()">Pesan</button>
        </form>

        <!-- tampilan konfirmasi Popup -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Pemesanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin melanjutkan pemesanan tiket?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="button" class="btn btn-primary" id="confirmOrder">Ya</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        /* popup jika pesan di klik */
        function showPopup() {
            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();

            document.getElementById('confirmOrder').onclick = function() {
                console.log("Button 'Ya' clicked");
                document.getElementById('ticketForm').action = 'html/dashboard.html';
                document.getElementById('ticketForm').submit();
            }
        }
    </script>
</body>
</html>
