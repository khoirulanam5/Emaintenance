<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><b><?= $title ?></b></h3>
	</div>
	<?= $this->session->flashdata('pesan') ?>
	<div class="card shadow">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="dataTable">
					<thead>
						<tr>
							<th class="text-center" style="width: 5%;">NO</th>
							<th class="text-center" style="width: 15%;">ID Service</th>
							<th class="text-center" style="width: 10%;">Merk</th>
							<th class="text-center" style="width: 10%;">Supir</th>
							<th class="text-center" style="width: 10%;">Teknisi</th>
							<th class="text-center" style="width: 15%;">Tanggal Service</th>
							<th class="text-center" style="width: 15%;">Estimasi<br>Service</th>
							<th class="text-center" style="width: 20%;">Keterangan</th>
							<th class="text-center" style="width: 5%;">AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($service as $value) : ?>
							<tr class = "text-center">
								<td class="text-center"><?= $no++ ?></td>
								<td><?= $value->id_service ?></td>
								<td><?= $value->merk ?></td>
								<td><?= $value->nama_supir ?></td>
								<td><?= $value->nama_teknisi ?></td>
                                <td><?= date('d-m-Y', strtotime($value->tgl_service)) ?></td>
                                <td><?= $value->tgl_setelah_service ?></td>
                                <td><?= $value->uraian ?></td>
								<td>
									<?php if(empty($value->nama_teknisi)): ?>
                                    <a class="btn btn-sm btn-primary m-1" href="<?= base_url('admin/service/edit/'.$value->id_service) ?>"><i class="fas fa-edit fa-sm"></i></a>
									<?php endif; ?>
                                    <a class="btn btn-danger btn-sm m-1 hapus" href="<?= base_url('admin/service/delete/'.$value->id_service) ?>"><i class="fas fa-trash"></i></a>
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