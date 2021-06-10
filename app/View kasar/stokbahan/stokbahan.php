<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stok Bahan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
</head>

<body>

    <div class="container mt-5 mb-5 text-center">
        <h4>Stok Bahan</h4>
    </div>
    <div class="container">
        <?php
        if (!empty(session()->getFlashdata('success'))) { ?>

            <div class="alert alert-success">
                <?php echo session()->getFlashdata('success'); ?>
            </div>

        <?php } ?>
        <?php if (!empty(session()->getFlashdata('info'))) { ?>

            <div class="alert alert-info">
                <?php echo session()->getFlashdata('info'); ?>
            </div>

        <?php } ?>

        <?php if (!empty(session()->getFlashdata('warning'))) { ?>

            <div class="alert alert-warning">
                <?php echo session()->getFlashdata('warning'); ?>
            </div>

        <?php } ?>
    </div>
    <div class="container">

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>Tanggal Update</th>
                    <th>Nama Bahan</th>
                    <th>Sub Bahan</th>
                    <th>Satuan</th>
                    <th>Stok Awal</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Akhir</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($stok as $key => $data) { ?>
                        <tr>
                            <td><?php echo $data['updateDate']; ?></td>
                            <td><?php echo $data['nama']; ?></td>
                            <td><?php echo $data['subBahan']; ?></td>
                            <td><?php echo $data['satuan']; ?></td>
                            <td><?php echo $data['stokAwal']; ?></td>
                            <td><?php echo $data['stokMasuk']; ?></td>
                            <td><?php echo $data['stokKeluar']; ?></td>
                            <td><?php echo $data['stokAkhir']; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo ('/stokbahan/edit/' . $data['id']); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <form method="get" action="<?php echo ('/stokbahan') ?>">
                    <div class="col-md-2 col-sm-2 col-xs-2" align="center">Nama Bahan

                        <select class="form-control" name="nama">
                            <option>Semua</option>
                            <option value="Tepung">Tepung</option>
                            <option value="Minyak">Minyak</option>
                            <option value="Telur">Telur</option>
                        </select>
                    </div>
                    <br><input type="submit" class="btn btn-primary" value="Cari">
                </form>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>