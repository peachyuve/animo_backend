
<html>
    <head></head>
    <body>
        <table border="1px">
            <tr>
                <td>id</td>
                <td>Nama</td>
                <td>Sub Bahan</td>
                <td>Satuan</td>
                <td>Merk</td>
                <td>Supplier</td>
                <td>Contact/Url</td>
            </tr>
            <?php foreach($bahan as $bahan) : ?>
            <tr>
                <td><?= $bahan['uniqueCode'];?></td>
                <td><?= $bahan['nama'];?></td>
                <td><?= $bahan['subBahan'];?></td>
                <td><?= $bahan['satuan'];?></td>
                <td><?= $bahan['merk'];?></td>
                <td><?= $bahan['suplier'];?></td>
                <td><?= $bahan['linkSuplier'];?></td>
                <td>
                    <a href="<?php echo base_url('Data/editDataBahan/'.$bahan['uniqueCode']); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i><button>Edit</button></a>
                    <a href="<?php echo base_url('Data/proses_deleteDataBahan/'.$bahan['uniqueCode']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk <?php echo $bahan['nama']; ?> ini?')"><i class="fas fa-trash-alt"></i><button>Delete</button></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>
