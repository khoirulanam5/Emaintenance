<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><i class="fas fa-edit"></i> EDIT ASET KENDARAAN</h3>
	</div>
	<div class="card">
		<div class="card-body">
			<?php foreach ($aset as $value) : ?>
				<form action="<?= base_url('admin/dataaset/edit/' . $value->id_kendaraan) ?>" method="post" enctype='multipart/form-data'>
					<div class="row">
						<!-- Kolom Kiri -->
						<div class="col-md-6">
							<div class="form-group">
								<label for="no_aset">Nomer Aset</label>
								<input type="text" name="no_aset" id="no_aset" value="<?= set_value('no_aset', $value->no_aset) ?>" class="form-control" readonly>
								<?= form_error('no_aset', '<div class="text-danger small">', '</div>') ?>
							</div>

							<div class="form-group">
								<label for="no_polisi">Nama Kendaraan</label>
								<select name="no_polisi" id="no_polisi" class="form-control">
									<option value="">-- Pilih Kendaraan --</option>
									<?php foreach ($kendaraan as $val): ?>
										<option value="<?= $val->no_polisi ?>" <?= set_select('no_polisi', $val->no_polisi, ($value->no_polisi == $val->no_polisi)) ?>>
											<?= $val->merk ?>
										</option>
									<?php endforeach; ?>
								</select>
								<?= form_error('no_polisi', '<div class="text-danger small">', '</div>') ?>
							</div>

							<div class="form-group">
								<label for="no_rangka">Nomer Rangka</label>
								<input type="text" name="no_rangka" id="no_rangka" value="<?= set_value('no_rangka', $value->no_rangka) ?>" class="form-control">
								<?= form_error('no_rangka', '<div class="text-danger small">', '</div>') ?>
							</div>

							<div class="form-group">
								<label for="no_mesin">Nomer Mesin</label>
								<input type="text" name="no_mesin" id="no_mesin" value="<?= set_value('no_mesin', $value->no_mesin) ?>" class="form-control">
								<?= form_error('no_mesin', '<div class="text-danger small">', '</div>') ?>
							</div>

							<div class="form-group">
								<label for="masa_pajak">Masa Pajak</label>
								<input type="date" name="masa_pajak" id="masa_pajak" value="<?= set_value('masa_pajak', $value->masa_pajak) ?>" class="form-control">
								<?= form_error('masa_pajak', '<div class="text-danger small">', '</div>') ?>
							</div>

							<div>
								<a href="<?= base_url('admin/dataaset') ?>" class="btn btn-sm btn-primary">
									<i class="fas fa-long-arrow-alt-left"></i> Kembali
								</a>
							</div>
						</div>

						<!-- Kolom Kanan -->
						<div class="col-md-6">
							<div class="form-group">
								<label for="masa_stnk">Masa STNK</label>
								<input type="date" name="masa_stnk" id="masa_stnk" value="<?= set_value('masa_stnk', $value->masa_stnk) ?>" class="form-control">
								<?= form_error('masa_stnk', '<div class="text-danger small">', '</div>') ?>
							</div>

							<div class="form-group">
								<label for="masa_asuransi">Masa Asuransi</label>
								<input type="date" name="masa_asuransi" id="masa_asuransi" value="<?= set_value('masa_asuransi', $value->masa_asuransi) ?>" class="form-control">
								<?= form_error('masa_asuransi', '<div class="text-danger small">', '</div>') ?>
							</div>

							<div class="form-group">
								<label for="tgl_service_rutin">Tanggal Service Rutin</label>
								<input type="number" min="1" max="31" name="tgl_service_rutin" id="tgl_service_rutin" value="<?= set_value('tgl_service_rutin', $value->tgl_service_rutin) ?>" class="form-control">
								<?= form_error('tgl_service_rutin', '<div class="text-danger small">', '</div>') ?>
							</div>

							<div class="form-group">
								<label for="thn_pembuatan">Tahun Pembuatan</label>
								<select name="thn_pembuatan" id="thn_pembuatan" class="form-control">
									<option value="">-- Pilih Tahun Pembuatan --</option>
									<?php for ($i = 1990; $i <= date('Y'); $i++): ?>
										<option value="<?= $i ?>" <?= set_select('thn_pembuatan', $i, ($value->thn_pembuatan == $i)) ?>>
											<?= $i ?>
										</option>
									<?php endfor; ?>
								</select>
								<?= form_error('thn_pembuatan', '<div class="text-danger small">', '</div>') ?>
							</div>

							<div class="form-group">
								<label for="thn_pengadaan">Tahun Pengadaan</label>
								<select name="thn_pengadaan" id="thn_pengadaan" class="form-control">
									<option value="">-- Pilih Tahun Pengadaan --</option>
									<?php for ($i = 1990; $i <= date('Y'); $i++): ?>
										<option value="<?= $i ?>" <?= set_select('thn_pengadaan', $i, ($value->thn_pengadaan == $i)) ?>>
											<?= $i ?>
										</option>
									<?php endfor; ?>
								</select>
								<?= form_error('thn_pengadaan', '<div class="text-danger small">', '</div>') ?>
							</div>

							<div align="right">
								<button type="reset" class="btn btn-danger">Reset</button>
								<button type="submit" class="btn btn-primary">Simpan</button>
							</div>
						</div>
					</div>
				</form>
			<?php endforeach; ?>
		</div>
	</div>
</div>