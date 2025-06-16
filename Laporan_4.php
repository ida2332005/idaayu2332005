<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Set karakter encoding dan pengaturan tampilan responsive -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Penilaian Mahasiswa</title>

  <!-- Import Bootstrap CSS untuk styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="..." crossorigin="anonymous">

  <!-- Import Bootstrap JS untuk fungsi seperti alert dan modal -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
          integrity="..." crossorigin="anonymous"></script>

  <!-- CSS tambahan untuk desain halaman -->
  <style>
    body {
      background-color: #f8f9fa; /* Warna latar halaman */
    }

    .card-header {
      background-color: #007bff; /* Biru untuk header */
      color: white;
    }

    .form-label {
      font-weight: bold;
    }

    .hasil-box {
      border: 1px solid #dee2e6;
      background-color: white;
      color: black;
      padding: 0;
      border-radius: 5px;
      margin-top: 20px;
    }

    /* Styling untuk status LULUS */
    .status-lulus {
      color: white;
      background-color: #28a745;
      padding: 3px 10px;
      border-radius: 5px;
      font-weight: bold;
    }

    /* Styling untuk status TIDAK LULUS */
    .status-tidak-lulus {
      color: white;
      background-color: #dc3545;
      padding: 3px 10px;
      border-radius: 5px;
      font-weight: bold;
    }

    .btn-selesai {
      font-weight: bold;
      width: 100%; /* Lebar penuh */
    }
  </style>
</head>

<body>
  <!-- Container utama halaman -->
  <div class="container mt-4 mb-5 px-5">
    <div class="card shadow-sm">
      <!-- Judul di dalam card -->
      <div class="card-header text-center">
        <h1 class="h4 mb-0">Form Penilaian Mahasiswa</h1>
      </div>

      <div class="card-body">
        <!-- Form input nilai -->
        <form method="post">
          <!-- Input Nama -->
          <div class="mb-3">
            <label for="nama" class="form-label">Masukkan Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Agus" />
          </div>

          <!-- Input NIM -->
          <div class="mb-3">
            <label for="nim" class="form-label">Masukkan NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" placeholder="202332xxx" />
          </div>

          <!-- Input Nilai Kehadiran -->
          <div class="mb-3">
            <label for="kehadiran" class="form-label">Nilai Kehadiran (10%)</label>
            <input type="number" class="form-control" id="kehadiran" name="kehadiran" placeholder="0 - 100" min="0" max="100" />
          </div>

          <!-- Input Nilai Tugas -->
          <div class="mb-3">
            <label for="tugas" class="form-label">Nilai Tugas (20%)</label>
            <input type="number" class="form-control" id="tugas" name="tugas" placeholder="0 - 100" min="0" max="100" />
          </div>

          <!-- Input Nilai UTS -->
          <div class="mb-3">
            <label for="uts" class="form-label">Nilai UTS (30%)</label>
            <input type="number" class="form-control" id="uts" name="uts" placeholder="0 - 100" min="0" max="100" />
          </div>

          <!-- Input Nilai UAS -->
          <div class="mb-3">
            <label for="uas" class="form-label">Nilai UAS (40%)</label>
            <input type="number" class="form-control" id="uas" name="uas" placeholder="0 - 100" min="0" max="100" />
          </div>

          <!-- Tombol Proses -->
          <div class="d-grid gap-2">
            <button type="submit" name="proses" class="btn btn-primary">Proses</button>
          </div>
        </form>

        <!-- Proses perhitungan dan validasi menggunakan PHP -->
        <?php
        // Jika tombol proses ditekan
        if (isset($_POST['proses'])) {
            // Ambil data dari form
            $nama = trim($_POST['nama']);
            $nim = trim($_POST['nim']);
            $kehadiran = $_POST['kehadiran'];
            $tugas = $_POST['tugas'];
            $uts = $_POST['uts'];
            $uas = $_POST['uas'];

            // Validasi: jika ada kolom kosong
            if ($nama == "" || $nim == "" || $kehadiran == "" || $tugas == "" || $uts == "" || $uas == "") {
                // Tampilkan alert peringatan
                echo '
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                  Semua kolom harus diisi!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                // Hitung nilai akhir berdasarkan bobot
                $nilaiAkhir = ($kehadiran * 0.1) + ($tugas * 0.2) + ($uts * 0.3) + ($uas * 0.4);

                // Tentukan grade berdasarkan nilai akhir
                if ($nilaiAkhir >= 85) $grade = 'A';
                elseif ($nilaiAkhir >= 70) $grade = 'B';
                elseif ($nilaiAkhir >= 55) $grade = 'C';
                elseif ($nilaiAkhir >= 40) $grade = 'D';
                else $grade = 'E';

                // Default: tidak lulus
                $status = "TIDAK LULUS";
                $statusClass = "status-tidak-lulus";
                $headerColor = "#dc3545"; // merah
                $btnClass = "btn-danger";

                // Logika kelulusan: harus memenuhi semua nilai minimal
                if ($kehadiran >= 70 && $nilaiAkhir >= 60 && $tugas >= 40 && $uts >= 40 && $uas >= 40) {
                    $status = "LULUS";
                    $statusClass = "status-lulus";
                    $headerColor = "#28a745"; // hijau
                    $btnClass = "btn-success";
                }

                // Tampilkan hasil penilaian
                echo '
                <div class="hasil-box p-0">
                  <div class="card">
                    <div class="card-header text-white" style="background-color: '.$headerColor.';">
                      <strong>Hasil Penilaian</strong>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-center mb-3">
                        <div style="font-size: 1.25rem; font-weight: bold; margin-right: 100px;"><strong>Nama:</strong> '.$nama.'</div>
                        <div style="font-size: 1.25rem; font-weight: bold; margin-left: 100px;"><strong>NIM:</strong> '.$nim.'</div>
                      </div>
                      <hr>
                      <div class="nilai-item"><strong>Nilai Kehadiran:</strong> '.$kehadiran.'%</div>
                      <div class="nilai-item"><strong>Nilai Tugas:</strong> '.$tugas.'</div>
                      <div class="nilai-item"><strong>Nilai UTS:</strong> '.$uts.'</div>
                      <div class="nilai-item"><strong>Nilai UAS:</strong> '.$uas.'</div>
                      <div class="nilai-item"><strong>Nilai Akhir:</strong> '.number_format($nilaiAkhir, 2).'</div>
                      <div class="nilai-item"><strong>Grade:</strong> '.$grade.'</div>
                      <div class="nilai-item"><strong>Status:</strong> <span class="'.$statusClass.'">'.$status.'</span></div>
                      <div class="mt-4 text-center">
                        <a href="" class="btn '.$btnClass.' btn-selesai">Selesai</a>
                      </div>
                    </div>
                  </div>
                </div>';
            }
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
