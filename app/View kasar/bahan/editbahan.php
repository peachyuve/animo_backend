<html>
    <head>
        <body>
        <?= \Config\Services::validation()->listErrors() ?>
        <form action="<?php echo base_url('Bahan/proses_editDataBahan/'); ?>" method='post'>

            <input type="id" name="id" value="<?= $bahan['id'] ?>" hidden />

            <label for="body">Nama</label>
            <input value="<?= $bahan['nama'] ?>" type="nama" name="nama" /><br />

            <label for="body">Kategori</label>
            <input value="<?= $bahan['kategori'] ?>" type="kategori" name="kategori" /><br />

            <label for="body">Id User</label>
            <input value="<?= $bahan['idUser'] ?>" type="idUser" name="idUser" /><br />

            <label for="body">satuan</label>
            <input value="<?= $bahan['satuan'] ?>" type="satuan" name="satuan" /><br />
            
            <label for="body">sub Bahan</label>
            <input value="<?= $bahan['subBahan'] ?>" type="subBahan" name="subBahan" /><br />
            
            <label for="body">merk</label>
            <input value="<?= $bahan['merk'] ?>" type="merk" name="merk" /><br />
            
            <label for="body">suplier</label>
            <input value="<?= $bahan['suplier'] ?>" type="suplier" name="suplier" /><br />

            <label for="body">link Suplier</label>
            <input value="<?= $bahan['linkSuplier'] ?>" type="linkSuplier" name="linkSuplier" /><br />


            <input type="submit" name="submit" value="Submit" />
        </form>
        </body>
    
    
    </head>

</html>