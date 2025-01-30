<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><b><?= $title?></b></h3>
	</div>
	<a href="<?= base_url('admin/dataaset/add') ?>" class="btn btn-sm btn-primary mb-3"><i class="fas fa-plus fa-sm"></i> Tambah</a>
	<?= $this->session->flashdata('pesan') ?>
	<div class="card shadow">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="dataTable">
					<thead>
						<tr>
							<th class="text-center">NO</th>
							<th class="text-center">ID Kendaraan</th>
							<th class="text-center">No. Aset</th>
							<th class="text-center">No. Polisi</th>
							<th class="text-center">No. Rangka</th>
							<th class="text-center">No. Mesin</th>
							<th class="text-center">Tanggal<br>Service Rutin</th>
							<th class="text-center">AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($aset as $value) : ?>
							<tr class = "text-center">
								<td class="text-center"><?= $no++ ?></td>
								<td><?= $value->id_kendaraan ?></td>
								<td><?= $value->no_aset ?></td>
								<td><?= $value->no_polisi ?></td>
								<td><?= $value->no_rangka ?></td>
								<td><?= $value->no_mesin ?></td>
                                <td><?= $value->tgl_service_rutin ?></td>
								<td>
                                    <a class="btn btn-success btn-sm m-1" href="<?= base_url('admin/dataaset/detail/'.$value->id_kendaraan) ?>"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-sm btn-primary m-1" href="<?= base_url('admin/dataaset/edit/'.$value->id_kendaraan) ?>"><i class="fas fa-edit fa-sm"></i></a>
                                    <a class="btn btn-danger btn-sm m-1 hapus" href="<?= base_url('admin/dataaset/delete/'.$value->id_kendaraan) ?>"><i class="fas fa-trash"></i></a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
   document.querySelectorAll('.hapus').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah link agar tidak langsung dijalankan
            var url = this.getAttribute('href'); // Ambil URL dari atribut href
            Swal.fire({
                title: "Hapus Data?",
                text: "Data yang sudah dihapus tidak dapat dipulihkan kembali!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, redirect ke URL penghapusan
                    window.location.href = url;
                }
            });
        });
    });
</script>