<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Service</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        body {
            margin: 30px;
            margin-top: 70px;
            margin-left: 50px;
            margin-right: 50px;
            font-family: Arial, sans-serif;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
        .header-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-logo {
            height: 100px;
        }
        .header-text {
            text-align: center;
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header-container">
        <!-- <div>
            <img src="<?= base_url('assets/logo.png') ?>" alt="Logo" class="header-logo">
        </div> -->
        <div class="header-text">
            <h2><b>CV. MANDIRI MULYA TRANSLOGISTIC</b></h2>
            <p>Alamat: Desa Karangbener Kec. Bae Kabupaten Kudus Jawa Tengah 59322.<br>
               Telepon: (0291) 657443
            </p>
        </div>
    </div>
    <hr style="border: 2px solid black;">
    
    <!-- Content Section -->
    <h3 style="text-align: left;">Data Riwayat Service</h3>
    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">NO</th>
				<th class="text-center" style="width: 15%;">ID Service</th>
				<th class="text-center" style="width: 10%;">Merk Kendaraan</th>
				<th class="text-center" style="width: 10%;">Nama Supir</th>
				<th class="text-center" style="width: 10%;">Nama Teknisi</th>
				<th class="text-center" style="width: 15%;">Tanggal Service</th>
				<th class="text-center" style="width: 15%;">Tanggal<br>Selesai</th>
				<th class="text-center" style="width: 15%;">Keterangan<br>Kerusakan</th>
            </tr>
        </thead>
        <tbody>
            <?php
				$no = 1;
				foreach ($riwayat as $value) : ?>
				<tr class = "text-center">
					<td class="text-center"><?= $no++ ?></td>
					<td><?= $value->id_service ?></td>
					<td><?= $value->merk ?></td>
					<td><?= $value->nama_supir ?></td>
					<td><?= $value->nama_teknisi ?></td>
                    <td><?= do_formal_date($value->tgl_service) ?></td>
                    <td><?= do_formal_date($value->tgl_setelah_service) ?></td>
                    <td><?= $value->uraian ?></td>
				</tr>
			<?php endforeach; ?>
        </tbody>
    </table>
    
    <script>
        window.print();
    </script>
</body>
</html>
