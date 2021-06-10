<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Produk</title>
</head>

<body>

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
        <a href="<?php echo base_url('produk/create'); ?>" class="btn btn-success float-right mb-3">Tambah Produk</a>
        <div class="table-responsive">
            <div class="table-responsive">
                <table class="table table-bordered" border="1">
                    <thead>
                        <th>No</th>
                        <th>Unik</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php


                        $key = 1;

                        if ($produk == false) {
                            echo ("Data Tidak ada");
                        } else {
                            foreach ($produk as $data) { ?>
                                <tr>

                                    <td><?php echo $key++; ?></td>
                                    <td><?php echo $data['uniqueCode'];  ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo $data['nama_kategori']; ?> </td>
                                    <td><?php echo $data['ukuran']; ?></td>
                                    <td><?php echo $data['harga']; ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo base_url('produk/edit/' . $data['uniqueCode']); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i>Update</a>
                                            <a href="<?php echo base_url('produk/delete/' . $data['uniqueCode']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk <?php echo $data['nama']; ?> ini?')"><i class="fas fa-trash-alt"></i>Delete</a>
                                        </div>
                                    </td>
                                </tr>

                            <?php } ?>

                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
        <form action="/produk/index " method="post">
            <div class="input-group mb-3">
                <div class=" input-group mb-3">
                    <select name="nama_kategori">
                        <?php foreach ($kategori as $l) { ?>
                            <option value=<?php echo $l['nama_kategori']; ?>><?php echo $l['nama_kategori']; ?></option>
                        <?php } ?>
                    </select>

                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Filter</button>
                    </div>
                </div>
        </form>
</body>


</html>