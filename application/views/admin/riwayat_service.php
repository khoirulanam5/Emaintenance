<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><b><?= $title ?></b></h3>
	</div>
    <a href="<?= base_url('admin/riwayatservice/print') ?>" class="btn btn-sm btn-primary mb-3"><i class="fas fa-print fa-sm"></i> Print</a>
	<?= $this->session->flashdata('pesan') ?>
	<div class="card shadow">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="dataTable">
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
							<th class="text-center" style="width: 5%;">Status</th>
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
                                <td><?= $value->status ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>