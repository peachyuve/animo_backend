<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Dashboard</h1>
    <h3>
    <?php 
        echo "Today is " . date("D, d m Y");
        ?>
    </h3>
    
    <h2>Pesanan</h2>
    <table border="1px">
        <tr>
            <th>UniqueCode</th>
            <th>Nama Produk</th>
            <th>harga</th>
            <th>ukuran</th>
            <th>jumlah</th>
        </tr>
        
        <?php if($pesanan){ ?>
        <?php foreach($pesanan as $pesanan) : ?>
            <tr>
                <td><?= $pesanan['uniqueCode'];?></td>
                <td><?= $pesanan['nama'];?></td>
                <td><?= $pesanan['harga'];?></td>
                <td><?= $pesanan['ukuran'];?></td>
                <td><?= $pesanan['jumlah'];?></td>
            </tr>
        <?php endforeach; ?>
        <?php } ?>
    </table>
    <br>
    <h2>STOCK</h2>
    <table border="1px">
        <tr>
            <th>Nama</th>
            <th>Stok</th>
            <th>Ukuran</th>
        </tr>
        <?php if($stock){ ?>
        <?php foreach($stock as $stock) : ?>
            <tr>
                <td><?= $stock['nama'];?></td>
                <td><?= $stock['stokAkhir'];?></td>
                <td><?= $stock['satuan'];?></td>
            </tr>
        <?php endforeach; ?>
        <?php } ?>
    </table>
</body>
</html>