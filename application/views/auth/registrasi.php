<!DOCTYPE html>
<html lang="en">

<head>
    <title>CV. Mandiri Mulya Translogistic</title>
</head>

<body class="bg-gradient-primary">

    <body class="bg-gradient-primary">

        <div class="container">

            <div class="card o-hidden border-0 shadow-lg col-lg-6 my-5 mx-auto">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Daftar Akun</h1>
                                </div>
                                <form method="post" action="<?= base_url('auth/register') ?>">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" placeholder="Nama Anda..." name="nama" required>
                                        <?= form_error('nama', '<div class="text-danger small ml-2">', '</div>') ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Username Anda..." name="username" required>
                                        <?= form_error('username', '<div class="text-danger small ml-2">', '</div>') ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" placeholder="Password Anda..." name="password" required>
                                        <?= form_error('password', '<div class="text-danger small ml-2">', '</div>') ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_hp">No. Telp</label>
                                        <input type="number" class="form-control" id="no_hp" placeholder="No. Telp Anda..." name="no_hp" required>
                                        <?= form_error('password', '<div class="text-danger small ml-2">', '</div>') ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Jabatan</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="">-- Pilih Jenis Jabatan --</option>
                                            <option value="teknisi">Teknisi</option>  
                                            <option value="supir">Supir</option>
                                        </select>
                                    </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Daftar</button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/login') ?>">Sudah Punya Akun? Silakan Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </body>

</html>