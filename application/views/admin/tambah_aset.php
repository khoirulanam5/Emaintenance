<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><i class="fas fa-plus"></i> TAMBAH ASET KENDARAAN</h3>
	</div>
	<?= $this->session->flashdata('pesan') ?>
	<div class="card">
		<div class="card-body">
			<form action="<?= base_url('admin/dataaset/add') ?>" method="post" enctype='multipart/form-data'>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Kendaraan</label>
                            <select name="no_polisi" id="no_polisi" class="form-control">
                                <option value="">--Pilih Kendaraan--</option>
                                <?php  foreach($kendaraan as $value): ?>
                                <option value="<?= $value->no_polisi ?>"><?= $value->merk ?> - <?= $value->no_polisi ?></option>
                                <?php endforeach; ?>
                            </select>
							<?php echo form_error('no_polisi', '<div class="text-danger small ml-3">', '</div>') ?>
						</div>
						<div class="form-group">
							<label>Nomer Rangka</label>
							<input type="text" name="no_rangka" id="no_rangka" class="form-control">
							<?php echo form_error('no_rangka', '<div class="text-danger small ml-3">', '</div>') ?>
						</div>
						<div class="form-group">
							<label>Nomer Mesin</label>
							<input type="text" name="no_mesin" id="no_mesin" class="form-control">
							<?php echo form_error('no_mesin', '<div class="text-danger small ml-3">', '</div>') ?>
						</div>
						<div class="form-group">
							<label>Masa Pajak</label>
							<input type="date" name="masa_pajak" id="masa_pajak" class="form-control">
						</div>
						<div>
							<a href="<?php echo base_url('admin/dataaset') ?>">
								<div class="btn btn-sm btn-primary"><i class="fas fa-long-arrow-alt-left"></i> Kembali</div>
							</a>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Masa STNK</label>
							<input type="date" name="masa_stnk" id="masa_stnk" class="form-control">
						</div>
						<div class="form-group">
							<label>Masa Asuransi</label>
							<input type="date" name="masa_asuransi" id="masa_asuransi" class="form-control">
						</div>
						<div class="form-group">
							<label>Tanggal Service Rutin</label>
							<input type="number" min="1" max="31" name="tgl_service_rutin" id="tgl_service_rutin" class="form-control">
						</div>
						<div class="form-group">
                            <label>Tahun Pembuatan</label>
                            <select name="thn_pembuatan" id="thn_pembuatan" class="form-control">
                                <option value="">-- Pilih Tahun Pembuatan --</option>
                                <?php for ($i = 1990; $i <= date('Y'); $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun Pengadaan</label>
                            <select name="thn_pengadaan" id="thn_pengadaan" class="form-control">
                                <option value="">-- Pilih Tahun Pengadaan --</option>
                                <?php for ($i = 1990; $i <= date('Y'); $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
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