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
            <?php foreach($bahan as $data) : ?>
            <tr>
                <td><?= $data['uniqueCode'];?></td>
                <td><?= $data['nama'];?></td>
                <td><?= $data['subBahan'];?></td>
                <td><?= $data['satuan'];?></td>
                <td><?= $data['merk'];?></td>
                <td><?= $data['suplier'];?></td>
                <td><?= $data['linkSuplier'];?></td>
                <td>
                    <a href="<?php echo base_url('bahan/edit/'.$data['uniqueCode']); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i><button>Edit</button></a>
                    <a href="<?php echo base_url('bahan/delete/'.$data['uniqueCode']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk <?php echo $data['nama']; ?> ini?')"><i class="fas fa-trash-alt"></i><button>Delete</button></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>
