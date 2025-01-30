<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h3 class="h3 mb-0 text-gray-800"><i class="fas fa-book"></i> DETAIL ASET KENDARAAN</h3>
	</div>

	<div class="card">
	  <h5 class="card-header">Detail Aset Kendaraan</h5>
	  <div class="card-body">

	  	<?php foreach ($aset as $value) : ?>

	  	<div class="row">
	  		
	  		<div class="col-md-4">
	    	<img src="<?= base_url('assets/img/kendaraan/'.$value->foto)?>" class="card-img-top">
	    </div>
	    <div class="col-md-8">
	    	<table class="table">
	    		<tr>
	    			<td>ID Kendaraan</td>
	    			<td><strong>: <?php echo $value->id_kendaraan ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Nomer Polisi</td>
	    			<td><strong>: <?php echo $value->no_polisi ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Nomer Aset</td>
	    			<td><strong>: <?php echo $value->no_aset ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Nomer Rangka</td>
	    			<td><strong>: <?php echo $value->no_rangka ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Nomer Mesin</td>
	    			<td><strong>: <?php echo $value->no_mesin ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Merk</td>
	    			<td><strong>: <?php echo $value->merk ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Type</td>
	    			<td><strong>: <?php echo $value->type ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Masa Pajak</td>
	    			<td><strong>: <?= do_formal_date($value->masa_pajak) ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Masa STNK</td>
	    			<td><strong>: <?= do_formal_date($value->masa_stnk) ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Masa Asuransi</td>
	    			<td><strong>: <?= do_formal_date($value->masa_asuransi) ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Tanggal Service Rutin</td>
	    			<td><strong>: <?php echo $value->tgl_service_rutin ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Tahun Pembuatan</td>
	    			<td><strong>: <?php echo $value->thn_pembuatan ?></strong></td>
	    		</tr>
	    		<tr>
	    			<td>Tahun Pengadaan</td>
	    			<td><strong>: <?php echo $value->thn_pengadaan ?></strong></td>
	    		</tr>
	    	</table>

			<div align="left">
				<a class="btn btn-sm btn-primary" href="<?= base_url('admin/dataaset/') ?>">Kembali</a>
			</div>

	    </div>

	  	</div>
	    
		<?php endforeach; ?>
	  </div>
	</div>

</div>