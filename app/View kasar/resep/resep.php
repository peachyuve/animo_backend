<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

    <h1>Resep</h1>
        <h3>
        <?php 
            echo "Today is " . date("D, d m Y");
        ?>
        </h3>
        
        <h2>produk</h2>
        <table border="1px">
            <tr>
                <th>Nama Produk</th>
            
            <?php foreach($namaproduk as $namaproduk) : ?>
                <tr>
                    <td><?= $namaproduk['nama'];?></td>
                </tr>
            <?php endforeach; ?>
            </tr>
        </table>

        <h2>List Bahan Baku</h2>
        <table border="1px">
            <tr>
                <th>Nama Bahan Baku</th>
            
            <?php foreach($GetBahanBaku as $bahanbaku) : ?>
                <tr>
                    <td><?= $bahanbaku['nama'];?></td>
                </tr>
            <?php endforeach; ?>
            </tr>
        </table>

        <h2>List SubBahan</h2>
        <table border="1px">
            <tr>
                <th>Nama SubBahan</th>
            
            <?php foreach($listSubBahan as $listSubBahan) : ?>
                <tr>
                    <td><?= $listSubBahan['subBahan'];?></td>
                </tr>
            <?php endforeach; ?>
            </tr>
        </table>

        <h2>List Resep</h2>

        <table id="nilai" border="1px" >
            <tr>
                <th>Sub-Bahan</th>
                <th>Jumlah/Sub-Bahan</th>
                <th>Harg/Sub-Bahan</th>
                <th>Harga/Satuan</th>
                <th>Ukuran Resep</th>
                <th>Harga</th>
                
            
            <?php foreach($viewResep as $viewResep) : ?>
                <tr>
                    <td><?= $viewResep['subBahan'];?></td>
                    <td><?= $viewResep['jumBahan'];?></td>
                    <td><?= $viewResep['hargaBahan'];?></td>
                    <td><?= $viewResep['hargaPerSatuan'];?></td>
                    <td><?= $viewResep['ukuranResep'];?></td>
                    <td></td>
                </tr>
                
            <?php endforeach; ?>
            <tr>
                    <td colspan="5"></td>
                    <td></td>
                    <php $query	= mysql_query("INSERT INTO porsi (totBiaya) value('$totalharga')");?>
            </tr>
            <tr>
                    
                    <td colspan="5"></td>
                    <td value="id='isinya'"> <?php echo $Porsi['jumPorsi'] ?> </td>
            </tr>
            <tr>
                    <td colspan="5"></td>
                    <td></td>
            </tr>
            </tr>
            
        </table>


        <script>
            var table = document.getElementById("nilai"), ukuranResep=0;
            var totalharga = 0;
            var x = 0;
            for(var r = 1; r < table.rows.length; r++)
            {
                var total =0;
                if (r < table.rows.length-3){
                    hargaPerSatuan = table.rows[r].cells[3].innerHTML;
                    ukuranResep = table.rows[r].cells[4].innerHTML;
                    total = total + (hargaPerSatuan*ukuranResep) ;
                    totalharga = totalharga + total;
                    console.log(totalharga);
                    table.rows[r].cells[5].innerHTML = total;
                    
                    
                }
                x = r;
                console.log(x);
            }
            
            table.rows[x-2].cells[1].innerHTML = totalharga;
            table.rows[x].cells[1].innerHTML = totalharga / table.rows[x-1].cells[1].innerHTML;

            
        </script>
</body>
</html>