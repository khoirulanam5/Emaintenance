<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><b><?= $title?></b></h3>
	</div>
	<button class="btn btn-sm btn-primary mb-3" data-toggle="modal" data-target="#add"><i class="fas fa-plus fa-sm"></i> Tambah</button>
	<?= $this->session->flashdata('pesan') ?>
	<div class="card shadow">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="dataTable">
					<thead>
						<tr>
							<th class="text-center">NO</th>
							<th class="text-center">No. Polisi</th>
							<th class="text-center">Merk</th>
              <th class="text-center">Type</th>
              <th class="text-center">Foto</th>
              <th class="text-center">Status</th>
							<th class="text-center">AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($kendaraan as $value) : ?>
							<tr class = "text-center">
								<td class="text-center"><?= $no++ ?></td>
								<td><?= $value->no_polisi ?></td>
								<td><?= $value->merk ?></td>
                <td><?= $value->type ?></td>
                <td>
                  <?php if(!empty($value->foto)): ?>
                    <a href="<?= base_url('assets/img/kendaraan/'.$value->foto) ?>" target="_blank">
                      <img src="<?= base_url('assets/img/kendaraan/'.$value->foto) ?>" alt="" style="height: 50px; width: 50px; object-fit: cover;">
                    </a>
                  <?php else: ?>
                    <span>Tidak ada foto</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($value->is_ready == '0'): ?>
                    <span class="badge bg-warning" style="color: white;">Maintenance</span>
                  <?php elseif ($value->is_ready == '1'): ?>
                    <span class="badge bg-success" style="color: white;">Ready</span>
                  <?php endif; ?>
                </td>
								<td>
                  <button class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#edit<?= $value->no_polisi ?>"><i class="fas fa-edit fa-sm"></i></button>
                  <a class="btn btn-danger btn-sm m-1 hapus" href="<?= base_url('admin/datakendaraan/delete/'.$value->no_polisi) ?>"><i class="fas fa-trash"></i></a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kendaraan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span area-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('admin/datakendaraan/add') ?>" method="post" enctype="multipart/form-data">
        	<div class="form-group">
        		<label>No. Polisi</label>
        		<input type="text" name="no_polisi" id="no_polisi" class="form-control" required>
        	</div>
        	<div class="form-group">
        		<label>Merk</label>
        		<input type="text" name="merk" id="merk" class="form-control" required>
        	</div>
        	<div class="form-group">
        		<label>Type</label>
        		<input type="text" name="type" id="type" class="form-control" required>
        	</div>
            <div class="form-group">
        		<label>Foto</label>
        		<input type="file" name="foto" id="foto" class="form-control" required>
        	</div>
            <div class="form-group">
        		<label>Status</label>
        		<select class="form-control" name="is_ready" id="is_ready" required>
                    <option value="">-- Status Kendaraan --</option>
                    <option value="1">Ada</option>
                    <option value="0">Tidak ada</option>
                </select>
        	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php foreach ($kendaraan as $value): ?>
<div class="modal fade" id="edit<?= $value->no_polisi ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Supir</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span area-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="<?= base_url('admin/datakendaraan/edit/'.$value->no_polisi) ?>" method="post" enctype="multipart/form-data">
        	<div class="form-group">
        		<label>Merk</label>
            <input type="hidden" name="no_polisi" value="<?= $value->no_polisi ?>">
        		<input type="text" name="merk" id="merk" class="form-control" value="<?= $value->merk ?>" required>
        	</div>
        	<div class="form-group">
        		<label>Type</label>
        		<input type="text" name="type" id="type" class="form-control" value="<?= $value->type ?>" required>
        	</div>
            <div class="form-group">
        		<label>Foto</label>
        		<input type="file" name="foto" id="foto" class="form-control" value="<?= $value->foto ?>" required>
        	</div>
          <!-- <div class="form-group">
        		<label>Status</label>
        		<select class="form-control" name="is_ready" id="is_ready" required>
                    <option value="">-- Status Kendaraan --</option>
                    <option value="1" <?= $value->is_ready == '1' ? 'selected' : '' ?>>Ada</option>
                    <option value="0" <?= $value->is_ready == '0' ? 'selected' : '' ?>>Tidak Ada</option>
                </select>
        	</div> -->
          <input type="hidden" name="is_ready" value="<?= $value->is_ready ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>

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