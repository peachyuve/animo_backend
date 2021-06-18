<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
      crossorigin="anonymous"
    />
    <title>Animo | Stok Bahan</title>
    <?= $this->include('templates/template');?>
    <script defer="defer" src="source/stokBahan.9616e89f.js"></script>
  </head>

  <body>
    <div class="container-xxl position-relative p-0 d-flex">
      <div class="sidebar-container">
        <sidebar class="sidebar">
          <?= $this->include('templates/sidebar');?>
        </sidebar>
      </div>
      <main class="main">
        <header class="header">
          <?= $this->include('templates/header');?>
        </header>
        <div class="row align-items-center">
          <div class="col-12 col-md-6">
            <h2 class="list__title">Keseluruhan</h2>
          </div>
          <div class="col-12 col-md-6">
            <div class="filter">
              <div
                class="d-flex justify-content-between align-items-center mb-3"
              >
                <p class="filter__label">Nama Bahan</p>
              </div>
              <button
                class="filter__toggler w-100"
                id="filter-toggler"
                aria-expanded="false"
              >
                <h4><?= $selectedBahan ?></h4>
                <span>&gt;</span>
              </button>
              <ul id="filter-group" class="filter__group w-100">
                <li class="filter__value">
                  <a href="?bahan=all">
                    <h4>Semua Bahan</h4>
                  </a>
                </li>
                <?php foreach ($bahan as $keyBahan => $valBahan) { ?>
                <li class="filter__value">
                  <a href="?bahan=<?= $valBahan['id'] ?>">
                    <h4><?= $valBahan['nama'] ?></h4>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <table class="table table__bahan table__stok">
            <thead>
              <tr>
                <th>Diperbarui</th>
                <th>Nama Bahan</th>
                <th>Sub Bahan</th>
                <th>Satuan</th>
                <th>Stok Awal</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Stok Akhir</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <!-- hapus "table__empty--false" jika ingin memunculkan teks di bawah -->
                <td class="table__empty <?= ($stok)?'table__empty--false':null ?> pt-5" colspan="7">
                  Data bahan masih kosong, tambahkan melalui laman bahan
                </td>
              </tr>
              <?php foreach ($stok as $keyStok => $valStok) { ?>
              <tr class="align-middle">
                <td data-label="Diperbarui"><?= $valStok['tglUpdate'] ?></td>
                <td data-label="Nama" rowspan="2"><?= $valStok['nama'] ?></td>
                <td data-label="Sub Bahan"><?= $valStok['subBahan'] ?></td>
                <td data-label="Satuan"><?= $valStok['satuan'] ?></td>
                <td data-label="Stok Awal">
                  <span><?= $valStok['stokAwal'] ?></span>
                  <button
                    onclick="editStock({
                        idSubBahan: '<?= $valStok['id'] ?>',
                        namaSubBahan: '<?= $valStok['nama'] ?>',
                        jenisStok: 'awal',
                        satuan: '<?= $valStok['satuan'] ?>',
                        jumlah: <?= $valStok['stokAwal'] ?>,
                      })"
                    class="button-primary"
                  >
                    <img src="source/images/pen.svg" alt="Edit Icon" />
                  </button>
                </td>
                <td data-label="Masuk">
                  <span><?= $valStok['stokMasuk'] ?></span>
                  <button
                    onclick="editStock({
                        idSubBahan: '<?= $valStok['id'] ?>',
                        namaSubBahan: 'Segitiga <?= $valStok['nama'] ?>',
                        jenisStok: 'masuk',
                        satuan: '<?= $valStok['satuan'] ?>',
                        jumlah: <?= $valStok['stokMasuk'] ?>,
                      })"
                    class="button-primary"
                  >
                    <img src="source/images/pen.svg" alt="Edit Icon" />
                  </button>
                </td>
                <td data-label="Keluar">
                  <span><?= $valStok['stokKeluar'] ?></span>
                  <button
                    onclick="editStock({
                        idSubBahan: '<?= $valStok['id'] ?>',
                        namaSubBahan: 'Segitiga <?= $valStok['nama'] ?>',
                        jenisStok: 'keluar',
                        satuan: '<?= $valStok['satuan'] ?>',
                        jumlah: <?= $valStok['stokKeluar'] ?>,
                      })"
                    class="button-primary"
                  >
                    <img src="source/images/pen.svg" alt="Edit Icon" />
                  </button>
                </td>
                <td data-label="Stok Akhir"><?= $valStok['stokAkhir'] ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </main>
      <dialog class="dialog dialog__edit-stock" id="edit-stock" open>
        <div class="dialog__backdrop">
          <div class="dialog__box">
            <form action="" method="POST" id="form-edit-stock">
              <input type="hidden" name="jenisStok" />
              <!-- js will inject all of these -->
              <h2 class="sub-bahan" id="sub-bahan">Segitiga Biru</h2>
              <div class="text-center">
                <span class="button-primary noselect" id="minus-btn"
                  >&minus;</span
                >
                <input
                  type="number"
                  name="jumlah"
                  class="input-stock noselect"
                  id="jumlah-stok"
                  min="0"
                  step="10"
                />
                <span class="button-primary noselect" id="plus-btn"
                  >&plus;</span
                >
              </div>
              <h3 class="satuan" id="satuan">gram</h3>
              <div class="d-flex gap-3 pick-date">
                <label for="date-choosen" data-diperbarui="date">
                  <img src="source/images/calendar.svg" alt="Calendar" />
                  <!-- value pada input ini akan diikut sertakan pada http request -->
                  <!-- format date masih sama: yyyy-MM-dd -->
                  <input type="text" name="date" id="date-choosen" />
                </label>
                <!-- nilai ketiga input di bawah tidak dikirim pada http request -->
                <input
                  type="number"
                  class="input-date"
                  min="1"
                  data-diperbarui="tanggal"
                />
                <input
                  type="number"
                  class="input-date"
                  min="1"
                  max="12"
                  data-diperbarui="bulan"
                />
                <input
                  type="number"
                  class="input-date"
                  min="2000"
                  max="9999"
                  data-diperbarui="tahun"
                />
              </div>
              <div class="dialog__cta align-self-end">
                <button
                  type="button"
                  onclick="closeDialog()"
                  class="button-secondary"
                >
                  Batal
                </button>
                <button class="button-primary" type="submit">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </dialog>
    </div>

    <script>
      const editStockDialog = document.getElementById("edit-stock");
      const formEditStock = document.getElementById("form-edit-stock");
      const editStockFeedback = document.getElementById("edit-stock-feedback");
      const subBahanInput = document.getElementById("sub-bahan");
      const jumlahStok = document.getElementById("jumlah-stok");
      const satuanInput = document.getElementById("satuan");
      const minusBtn = document.getElementById("minus-btn");
      const plusBtn = document.getElementById("plus-btn");
      const tanggal = document.querySelector("[data-diperbarui='tanggal']");
      const bulan = document.querySelector("[data-diperbarui='bulan']");
      const tahun = document.querySelector("[data-diperbarui='tahun']");
      const dateChoosen = document.getElementById("date-choosen");
      function editStock({
        idSubBahan,
        namaSubBahan,
        jenisStok,
        satuan,
        jumlah,
      }) {
        editStockDialog.classList.add("appear");
        subBahanInput.textContent = namaSubBahan;
        satuanInput.textContent = satuan;

        formEditStock.forEach((el) => {
          switch (el.name) {
            case "jenisStok":
              el.value = jenisStok;
              break;
            case "jumlah":
              el.value = jumlah;
              break;
            case "date":
              let today = new Date();
              let day = "" + today.getDate();
              let month = "" + (1 + today.getMonth());

              if (day.length < 2) day = "0" + day;
              if (month.length < 2) month = "0" + month;

              let year = today.getFullYear();
              el.value = [year, month, day].join("-");
              tanggal.value = day;
              bulan.value = month;
              tahun.value = year;
              break;
          }
        });

        formEditStock.action = `/stokbahan/edit/${idSubBahan}`; // BE ADDING THIS - mengubah url form
      }
      function closeDialog() {
        editStockDialog.classList.remove("appear");
      }

      minusBtn.onclick = () => {
        if (jumlahStok.value === 0) return;
        jumlahStok.value--;
      };
      plusBtn.onclick = () => {
        jumlahStok.value++;
      };
      tanggal.onchange = () => {
        let numOfDate = daysInMonth(bulan.value, tahun.value);
        if (tanggal.value > numOfDate) tanggal.value = numOfDate;
        if (tanggal.value < 0) tanggal.value = 1;
        if (tanggal.value.toString().length < 2)
          tanggal.value = "0" + tanggal.value;
        let old = dateChoosen.value.split("-");
        old[2] = tanggal.value;
        dateChoosen.value = old.join("-");
      };
      bulan.onchange = () => {
        if (bulan.value > 12) bulan.value = 12;
        if (bulan.value < 0) bulan.value = 1;
        if (bulan.value.toString().length < 2) bulan.value = "0" + bulan.value;
        let old = dateChoosen.value.split("-");
        old[1] = bulan.value;
        dateChoosen.value = old.join("-");
      };
      tahun.onchange = () => {
        if (tahun.value < 2000 || tahun.value.toString().length !== 4)
          tahun.value = 2000;
        let old = dateChoosen.value.split("-");
        old[0] = tahun.value;
        dateChoosen.value = old.join("-");
      };
      function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
      }
    </script>
  </body>
</html>
