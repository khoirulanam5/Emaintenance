<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><i class="fas fa-cogs"></i> SERVICE KENDARAAN</h3>
	</div>
	<?= $this->session->flashdata('pesan') ?>
	<div class="card">
		<div class="card-body">
			<form action="<?= base_url('supir/service/add') ?>" method="post" enctype='multipart/form-data'>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Merk</label>
							<select name="id_kendaraan" id="id_kendaraan" class="form-control">
                                <option value="">--Pilih Kendaraan--</option>
                                <?php foreach($kendaraan as $value): ?>
                                <option value="<?= $value->id_kendaraan ?>"><?= $value->merk ?> - <?= $value->no_polisi ?></option>
                                <?php endforeach; ?>
                            </select>
							<?php echo form_error('id_kendaraan', '<div class="text-danger small ml-3">', '</div>') ?>
						</div>
						<div class="form-group">
                            <label>Keterangan Kerusakan</label>
                            <textarea name="uraian" id="uraian" class="form-control" rows="4"></textarea>
                            <?php echo form_error('uraian', '<div class="text-danger small ml-3">', '</div>') ?>
                        </div>
						<div>
							<a href="<?php echo base_url('supir/service/') ?>">
								<div class="btn btn-sm btn-primary"><i class="fas fa-long-arrow-alt-left"></i> Kembali</div>
							</a>
						</div>
						<div align="right">
							<button type="reset" class="btn btn-danger">Reset</button>
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</div>
				</div>
		
			</form>
		</div>
	</div>

</div>