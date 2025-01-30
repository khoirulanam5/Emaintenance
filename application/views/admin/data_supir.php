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
							<th class="text-center">ID Supir</th>
							<th class="text-center">Nama</th>
							<th class="text-center">No.Telp</th>
              <th class="text-center">Username</th>
              <th class="text-center">Jabatan</th>
              <th class="text-center">Status</th>
							<th class="text-center">AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($supir as $value) : ?>
							<tr class = "text-center">
								<td class="text-center"><?= $no++ ?></td>
								<td><?= $value->id_supir ?></td>
								<td><?= $value->nama ?></td>
								<td><?= $value->no_hp ?></td>
                <td><?= $value->username ?></td>
                <td><?= $value->role ?></td>
                <td>
                  <?php if ($value->is_ready == '0'): ?>
                    <span class="badge bg-warning" style="color: white;">Sedang Melakukan Maintenance</span>
                  <?php elseif ($value->is_ready == '1'): ?>
                    <span class="badge bg-success" style="color: white;">Ready</span>
                  <?php endif; ?>
                </td>
								<td>
                  <button class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#edit<?= $value->id_user ?>"><i class="fas fa-edit fa-sm"></i></button>
                  <a class="btn btn-danger btn-sm m-1 hapus" href="<?= base_url('admin/datasupir/delete/'.$value->id_user) ?>"><i class="fas fa-trash"></i></a>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Supir</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span area-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('admin/datasupir/add') ?>" method="post" enctype="multipart/form_data">
        	<div class="form-group">
        		<label>Nama</label>
        		<input type="text" name="nama" id="nama" class="form-control" required>
        	</div>
        	<div class="form-group">
        		<label>No.Telp</label>
        		<input type="number" name="no_hp" id="no_hp" class="form-control" required>
        	</div>
            <div class="form-group">
        		<label>Username</label>
        		<input type="text" name="username" id="username" class="form-control" required>
        	</div>
            <div class="form-group">
        		<label>Password</label>
        		<input type="password" name="password" id="password" class="form-control" required>
        	</div>
            <div class="form-group">
        		<label>Status</label>
        		<select class="form-control" name="is_ready" id="is_ready" required>
                <option value="">-- Status Supir --</option>
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

<?php foreach ($supir as $value): ?>
<div class="modal fade" id="edit<?= $value->id_user ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Supir</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span area-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('admin/datasupir/edit/'.$value->id_user) ?>" method="post" enctype="multipart/form_data">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="hidden" name="id_user" value="<?= $value->id_user ?>">
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $value->nama ?>" required>
                </div>
                <div class="form-group">
                    <label>No.Telp</label>
                    <input type="number" name="no_hp" id="no_hp" class="form-control" value="<?= $value->no_hp ?>" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= $value->username ?>" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control" value="<?= $value->password ?>" required>
                </div>
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