<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><i class="fas fa-edit"></i> EDIT SERVICE KENDARAAN</h3>
	</div>
	<div class="card">
		<div class="card-body">
            <form action="<?= base_url('admin/service/edit/' . $service->id_service) ?>" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Nama Teknisi -->
                        <div class="form-group">
                            <label>Nama Teknisi</label>
                            <input type="hidden" name="id_kendaraan" value="<?= $service->id_kendaraan ?>">
                            <input type="hidden" name="id_supir" value="<?= $service->id_supir ?>">
                            <input type="hidden" name="tgl_service" value="<?= $service->tgl_service ?>">
                            <select name="id_teknisi" id="id_teknisi" class="form-control">
                                <option value="">--Pilih Teknisi--</option>
                                <?php foreach ($teknisi as $val): ?>
                                    <option value="<?= $val->id_teknisi ?>" 
                                        <?= set_select('id_teknisi', $val->id_teknisi, $val->id_teknisi == $service->id_teknisi) ?>>
                                        <?= $val->nama ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('id_teknisi', '<div class="text-danger small ml-3">', '</div>') ?>
                        </div>

                        <!-- Uraian -->
                        <div class="form-group">
                            <label>Uraian</label>
                            <textarea name="uraian" id="uraian" class="form-control" rows="4"><?= set_value('uraian', $service->uraian) ?></textarea>
                            <?= form_error('uraian', '<div class="text-danger small ml-3">', '</div>') ?>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="<?= base_url('admin/service/') ?>" class="btn btn-sm btn-primary">
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
