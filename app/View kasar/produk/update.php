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
        <h4>Form Edit Produk</h4>
        <hr>
        <form action="<?php echo base_url('produk/update/' . $produk['uniqueCode']); ?>" method="post">

            <div class="form-group">
                <label for="">Nama Produk</label>
                <input type="text" name="nama" value="<?php echo $produk['nama']; ?>" class="form-control" placeholder="Nama Produk">
            </div>
            <div class="form-group">
                <label for="">Ukuran Produk</label>
                <input type="text" name="ukuran" value="<?php echo $produk['ukuran']; ?>" class="form-control" placeholder="Ukuran Produk">
            </div>

            <div class="form-group">
                <label for="">Harga Produk</label>
                <textarea name="harga" class="form-control" placeholder="harga Produk"><?php echo $produk['harga']; ?></textarea>
            </div>
            <div class="input-group mb-3">
                <select name="nama_kategori">
                    <option value="">Kategori</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Buah">Buah</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
</body>

</html>