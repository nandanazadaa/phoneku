# Konfigurasi Midtrans Callback untuk Update Status Payment Otomatis

## Overview
Sistem ini sudah dikonfigurasi untuk secara otomatis mengupdate status payment menjadi "completed" saat transaksi Midtrans terdeteksi berhasil.

## Fitur yang Sudah Diimplementasi

### 1. Callback Handler
- **File**: `app/Http/Controllers/Home/CheckoutController.php`
- **Method**: `midtransCallback()`
- **Route**: `POST /midtrans/callback`

### 2. Status Mapping
Sistem akan mengupdate status berdasarkan transaction status dari Midtrans:

| Midtrans Status | Payment Status | Order Status | Keterangan |
|----------------|----------------|--------------|------------|
| `capture` | `completed` | `diproses` | Pembayaran berhasil, order diproses |
| `settlement` | `completed` | `diproses` | Pembayaran berhasil, order diproses |
| `pending` | `pending` | `dibuat` | Menunggu pembayaran |
| `expire` | `failed` | `dibatalkan` | Pembayaran expired |
| `cancel` | `failed` | `dibatalkan` | Pembayaran dibatalkan |
| `deny` | `failed` | `dibatalkan` | Pembayaran ditolak |
| `refund` | `refunded` | `dibatalkan` | Pembayaran direfund |

### 3. Logging
Sistem mencatat semua perubahan status untuk audit trail:
- Log saat callback diterima
- Log perubahan status payment dan order
- Log error jika terjadi masalah

## Konfigurasi Midtrans Dashboard

### 1. Login ke Midtrans Dashboard
- Buka https://dashboard.midtrans.com/
- Login dengan akun Anda

### 2. Set Callback URL
1. Pilih menu **Settings** → **Configuration**
2. Scroll ke bagian **Callback URL**
3. Masukkan URL callback:
   ```
   https://yourdomain.com/midtrans/callback
   ```
   atau untuk development:
   ```
   http://localhost:8000/midtrans/callback
   ```

### 3. Verifikasi Konfigurasi
- Pastikan callback URL dapat diakses dari internet
- Test dengan melakukan transaksi test
- Cek log Laravel untuk memastikan callback diterima

## Testing Callback

### 1. Test Transaksi
1. Lakukan transaksi test di aplikasi
2. Selesaikan pembayaran
3. Cek status order di admin panel

### 2. Cek Log
```bash
tail -f storage/logs/laravel.log
```

### 3. Manual Test Callback
Anda dapat test callback secara manual dengan mengirim POST request:

```bash
curl -X POST http://yourdomain.com/midtrans/callback \
  -H "Content-Type: application/json" \
  -d '{
    "order_id": "ORD-1234567890",
    "transaction_status": "settlement",
    "transaction_id": "TEST-123456"
  }'
```

## Troubleshooting

### 1. Callback Tidak Diterima
- Pastikan URL callback benar dan dapat diakses
- Cek firewall dan security settings
- Pastikan route sudah terdaftar: `php artisan route:list | grep midtrans`

### 2. Status Tidak Berubah
- Cek log Laravel untuk error
- Pastikan order_code di database sesuai dengan order_id dari Midtrans
- Verifikasi field `payment_status` ada di database

### 3. Error 404
- Pastikan route `/midtrans/callback` sudah terdaftar
- Clear route cache: `php artisan route:clear`

## Keamanan

### 1. Signature Key Verification
Untuk production, sebaiknya tambahkan verifikasi signature key:

```php
// Di method midtransCallback
$signatureKey = $request->header('X-Signature-Key');
if (!$this->verifySignature($request->all(), $signatureKey)) {
    Log::error('Invalid signature key');
    return response()->json(['error' => 'Invalid signature'], 400);
}
```

### 2. IP Whitelist
Tambahkan IP whitelist untuk Midtrans di production:
- Midtrans IP ranges: https://docs.midtrans.com/docs/environment-and-credentials

## Monitoring

### 1. Log Monitoring
Monitor log untuk:
- Callback yang diterima
- Perubahan status
- Error yang terjadi

### 2. Database Monitoring
Monitor tabel `orders` untuk:
- Status payment yang berubah
- Timestamp perubahan

### 3. Alert System
Implementasi alert untuk:
- Callback yang gagal
- Status yang tidak berubah setelah waktu tertentu
- Error yang berulang 