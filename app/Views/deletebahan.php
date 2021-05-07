<html>
    <head>
        <body>
        <?= \Config\Services::validation()->listErrors() ?>
        <form action="Data/proses_deleteDataBahan/" method='post'>
            <?= csrf_field() ?>

            <label for="body">id</label>
            <input type="id" name="id" /><br />

            <label for="body">Nama</label>
            <input type="nama" name="nama" /><br />

            <label for="body">Kategori</label>
            <input type="kategori" name="kategori" /><br />

            <label for="body">Id Resep</label>
            <input type="idUser" name="idUser" /><br />

            <label for="body">satuan</label>
            <input type="satuan" name="satuan" /><br />
            
            <label for="body">sub Bahan</label>
            <input type="subBahan" name="subBahan" /><br />
            
            <label for="body">merk</label>
            <input type="merk" name="merk" /><br />
            
            <label for="body">suplier</label>
            <input type="suplier" name="suplier" /><br />

            <label for="body">link Suplier</label>
            <input type="linkSuplier" name="linkSuplier" /><br />


            <input type="submit" name="submit" value="Submit" />
        </form>
        </body>
    
    
    </head>

</html>