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
        <h4>Halaman Stok Bahan-Edit Produk</h4>
    </div>
    <div class="container">
        <h4>Form Edit Produk</h4>
        <?php foreach ($stok as $row) : ?>
            <hr>

            <form action="<?php echo ('/stokbahan/update/' . $row['id']); ?>" method="post">

                <div class="form-group">
                    <label for="">Update Date</label>
                    <input type="date" name="updateDate" value="<?php echo $row['updateDate']; ?>" class="form-control" placeholder="Tanggal Update">
                </div>
                <div class="form-group">
                    <label for="">Stok Awal</label>
                    <input type="number" name="stokAwal" value="<?php echo $row['stokAwal']; ?>" class="form-control" placeholder="Stok Awal">
                </div>
                <div class="form-group">
                    <label for="">Stok Masuk</label>
                    <input type="number" name="stokMasuk" value="<?php echo $row['stokMasuk']; ?>" class="form-control" placeholder="Stok Masuk">
                </div>
                <div class="form-group">
                    <label for="">Stok Keluar</label>
                    <input type="number" name="stokKeluar" value="<?php echo $row['stokKeluar']; ?>" class="form-control" placeholder="Stok Keluar">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
</body>

</html>