<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><i class="fas fa-edit"></i> EDIT SERVICE KENDARAAN</h3>
	</div>
	<div class="card">
		<div class="card-body">
            <form action="<?= base_url('teknisi/service/edit/' . $service->id_service) ?>" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Nama Teknisi -->
                        <div class="form-group">
                            <label>Nama Teknisi</label>
                            <input type="hidden" name="id_kendaraan" value="<?= $service->id_kendaraan ?>">
                            <input type="hidden" name="id_supir" value="<?= $service->id_supir ?>">
                            <input type="hidden" name="tgl_service" value="<?= $service->tgl_service ?>">
                            <input type="hidden" name="id_teknisi" value="<?= $service->id_teknisi ?>">
                        </div>
                        <!-- Uraian -->
                        <div class="form-group">
                            <label>Keterangan Kerusakan</label>
                            <textarea name="uraian" id="uraian" class="form-control" rows="4"><?= set_value('uraian', $service->uraian) ?></textarea>
                            <?= form_error('uraian', '<div class="text-danger small ml-3">', '</div>') ?>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Estimasi Service Selesai</label>
                            <input type="date" name="tgl_setelah_service" id="tgl_setelah_service" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="<?= base_url('teknisi/service/') ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-long-arrow-alt-left"></i> Kembali
                    </a>
                    <div>
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
		</div>
	</div>
</div>
