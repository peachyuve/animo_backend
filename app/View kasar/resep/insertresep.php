<html>
    <head>
        <body>
        <?= \Config\Services::validation()->listErrors() ?>
        <form method="post" action="
            <?php if ($langkah == 'produk' || !isset($langkah)) {
                echo '/resep/insert?langkah=bahan';
            }elseif ($langkah == 'bahan') {
                echo '/resep/insert?langkah=data';
            }elseif ($langkah == 'data') {
                echo '/resep/insert?langkah=porsi';
            }elseif ($langkah == 'porsi') {
                echo '/resep/proses_insertDataResep';
            } ?>
            "
        >
            <?= csrf_field() ?>

            <?php if($langkah == 'produk' || !isset($langkah)){ ?>
                <label>produk</label>
                <input type="text" name="produk"><br>
            <?php } ?>

            <?php if($langkah == 'bahan'){ ?>
                <label>subbahan</label>
                <input type="text" name="subbahan"><br>
                <input type="text" name="produkId" value="<?= $produkId ?>" readonly><br>
            <?php } ?>

            <?php if($langkah == 'data'){ ?>
                <label>jumBeli</label>
                <input type="text" name="jumBeli"><br>

                <label>hargaBeli</label>
                <input type="text" name="hargaBeli"><br>

                <label>ukuranResep</label>
                <input type="text" name="ukuranResep"><br>
                
                <input type="text" name="bahanId" value="<?= $bahanId ?>" readonly><br>
                <input type="text" name="produkId" value="<?= $produkId ?>" readonly><br>
            <?php } ?>

            <?php if($langkah == 'porsi'){ ?>
                <label>jumPorsi</label>
                <input type="text" name="jumPorsi"><br>

                <input type="text" name="jumBeli" value="<?= $jumBeli ?>" readonly><br>
                <input type="text" name="hargaBeli" value="<?= $hargaBeli ?>" readonly><br>
                <input type="text" name="ukuranResep" value="<?= $ukuranResep ?>" readonly><br>
                <input type="text" name="bahanId" value="<?= $bahanId ?>" readonly><br>
                <input type="text" name="produkId" value="<?= $produkId ?>" readonly><br>
            <?php } ?>

            <input type="submit" name="submit" value="Submit" />
        </form>
        </body>
    
    
    </head>

</html>