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

    <title>Animo | Bahan</title>
    <?= $this->include('templates/template');?>
    <script defer="defer" src="source/bahan.dfe6ddce.js"></script>
  </head>

  <body>
    <div class="container-xxl position-relative p-0 d-flex">
      <div class="sidebar-container">
        <sidebar class="sidebar"">
          <?= $this->include('templates/sidebar');?>
        </sidebar>
      </div>
      <main class="main">
        <header class="header">
          <?= $this->include('templates/header');?>
        </header>
        <section class="bahan">
          <div id="bahan-all-items" class="bahan__all-items w-100">
            <div class="row align-items-center">
              <div class="col-12 col-md-7 mb-5 mb-md-0">
                <div id="add-material" class="add-item">
                  <button class="button-primary button--rounded-1">
                    &plus;
                  </button>
                  <p>Tambah Item</p>
                </div>
              </div>
              <div class="col-12 col-md-5">
                <div class="filter">
                  <div
                    class="
                      d-flex
                      justify-content-between
                      align-items-center
                      mb-3
                    "
                  >
                    <p class="filter__label">Kategori Bahan</p>
                    <button
                      class="button-primary button-primary__add-cat"
                      data-modal="add-material-cat"
                    >
                      &plus;
                    </button>
                  </div>
                  <button
                    class="filter__toggler w-100"
                    id="filter-toggler"
                    aria-expanded="false"
                  >
                    <h4><?= $selectedKategori['nama'] ?></h4>
                    <span>&gt;</span>
                  </button>
                  <ul id="filter-group" class="filter__group w-100">
                    <?php foreach($kategori as $keyKategori => $valKategori){ ?>
                    <li class="filter__value">
                      <a href="?kategori=<?= $valKategori['id'] ?>">
                        <h4><?= $valKategori['nama'] ?></h4>
                      </a>
                    </li>
                    <?php } ?>
                    <li data-modal="add-material-cat" class="filter__add">
                      + Tambah Kategori
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="row d-relative">
              <table class="table table__bahan">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Sub Bahan</th>
                    <th>Satuan</th>
                    <th>Merk</th>
                    <th>Supplier</th>
                    <th>Kontak/URL</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <!-- hapus "table__empty--false" jika ingin memunculkan teks di bawah -->
                    <td
                      class="table__empty table__empty--false pt-5"
                      colspan="7"
                    >
                      Belum ada bahan yang ditambahkan.
                    </td>
                  </tr>
                  <?php foreach ($bahan as $keyBahan => $valBahan) { ?>
                  <tr class="align-middle">
                    <td data-label="Nama"><?= $valBahan['nama'] ?></td> <!-- BE ADDING THIS - rowspand dihapus agar bisa responsif -->
                    <td data-label="Sub Bahan"><?= $valBahan['subBahan'] ?></td>
                    <td data-label="Satuan"><?= $valBahan['satuan'] ?></td>
                    <td data-label="Merk"><?= $valBahan['merk'] ?></td>
                    <td data-label="Supplier"><?= $valBahan['suplier'] ?></td>
                    <td data-label="Kontak/URL"><?= $valBahan['linkSuplier'] ?></td>
                    <td data-label="Aksi">
                      <button
                        onclick="editSub({
                        id: '<?= $valBahan['safeid'] ?>',
                        kategori:'<?= $selectedKategori['id'] ?>',
                        nama: '<?= $valBahan['safenama'] ?>',
                        sub: '<?= $valBahan['safesubBahan'] ?>',
                        satuan: '<?= $valBahan['safesatuan'] ?>',
                        merk: '<?= $valBahan['safemerk'] ?>',
                        supplier: '<?= $valBahan['safesuplier'] ?>',
                        kontak: '<?= $valBahan['safelinkSuplier'] ?>'
                      })"
                        class="button-primary"
                      >
                        <img src="source/images/pen.svg" alt="Edit Icon" />
                      </button>
                      <button onclick="delSub('<?= $valBahan['id'] ?>')" class="button-secondary">
                        <img src="source/images/trash.svg" alt="Delete Icon" />
                      </button>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div id="bahan-add-item" class="bahan__add-item w-100 mt-5 p-5">
            <form
              class="form"
              action="/bahan/input"
              name="form-add-material"
              method="POST"
            >
              <input type="hidden" name="idMaterial" />
              <div
                class="row justify-content-sm-center justify-content-md-start"
              >
                <div class="col-12 col-sm-8 col-md-6 mb-5">
                  <label class="form__label" for="select-category"
                    >Kategori Bahan</label
                  >
                  <select
                    class="form__select"
                    name="category"
                    id="select-category"
                  >
                    <?php foreach ($kategori as $keyKategori => $valKategori) { ?>
                    <option selected value="<?= $valKategori['id'] ?>"><?= $valKategori['nama'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div
                class="row justify-content-sm-center justify-content-md-start"
              >
                <div class="col-12 col-sm-8 col-md mb-5">
                  <label class="form__label" for="material">Nama Bahan</label>
                  <input
                    class="form__input"
                    type="text"
                    name="material"
                    id="material"
                  />
                </div>
                <div class="col-12 col-sm-8 col-md mb-5">
                  <label class="form__label" for="select-unit">Satuan</label>
                  <select
                    class="form__select form__select--narrow"
                    name="unit"
                    id="select-unit"
                  >
                    <option selected value="mililiter">mililiter</option>
                    <option value="gram">gram</option>
                    <option value="butir">butir</option>
                  </select>
                </div>
              </div>
              <div
                class="row justify-content-sm-center justify-content-md-start"
              >
                <div class="col-12 col-sm-8 col-md-6 mb-5">
                  <label class="form__label" for="sub-material"
                    >Sub Bahan</label
                  >
                  <input
                    class="form__input"
                    type="text"
                    name="subMaterial"
                    id="sub-material"
                  />
                </div>
              </div>
              <div
                class="row justify-content-sm-center justify-content-md-start"
              >
                <div class="col-12 col-sm-8 col-md-6 mb-5">
                  <label class="form__label" for="brand">Merk</label>
                  <input
                    class="form__input"
                    type="text"
                    name="brand"
                    id="brand"
                  />
                </div>
              </div>
              <div
                class="row justify-content-sm-center justify-content-md-start"
              >
                <div class="col-12 col-sm-8 col-md mb-5">
                  <label class="form__label" for="supplier">Supplier</label>
                  <input
                    class="form__input"
                    type="text"
                    name="supplier"
                    id="supplier"
                  />
                </div>
                <div class="col-12 col-sm-8 col-md mb-5">
                  <label class="form__label" for="contact"
                    >Kontak/URL Supplier</label
                  >
                  <input
                    class="form__input"
                    type="text"
                    name="contact"
                    id="contact"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col d-flex justify-content-end mt-5">
                  <button
                    class="button-grey form__button"
                    type="button"
                    onclick="cancelAddItem"
                    id="cancel-add"
                  >
                    Batal
                  </button>
                  <button
                    type="submit"
                    class="button-primary form__button"
                    style="margin-right: 0"
                  >
                    Simpan
                  </button>
                </div>
              </div>
            </form>
          </div>
        </section>
      </main>
      <dialog class="dialog dialog__add-prod-cat" id="add-material-cat" open>
        <div class="dialog__backdrop">
          <div class="dialog__box">
            <form id="form-add-material-cat" action="/bahan/kategori" method="POST">
              <input
                type="text"
                id="material-cat"
                name="category"
                placeholder="Masukkan Nama Kategori"
              />
              <div class="dialog__prompt">
                <span>Tekan <strong>Enter</strong> atau </span>
                <button
                  class="button-primary"
                  id="material-cat-save"
                  disabled="true"
                >
                  Tambah
                </button>
              </div>
            </form>
          </div>
        </div>
      </dialog>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.js"></script>
    <script>
      const bahanAllItems = document.getElementById("bahan-all-items");
      const bahanAddItem = document.getElementById("bahan-add-item");

      function editSub({
        id,
        kategori,
        nama,
        sub,
        satuan,
        merk,
        supplier,
        kontak,
      }) {
        bahanAllItems.classList.add("d-none");
        bahanAddItem.classList.add("d-block");
        document.forms["form-add-material"].forEach((el) => {
          switch (el.name) {
            case "idMaterial":
              el.value = id;
              break;
            case "material":
              el.value = nama;
              break;
            case "subMaterial":
              el.value = sub;
              break;
            case "brand":
              el.value = merk;
              break;
            case "supplier":
              el.value = supplier;
              break;
            case "contact":
              el.value = kontak;
              break;
            case "category":
              el.options.forEach((opt, idx) => {
                if (opt.value.toLowerCase() === kategori.toLowerCase()) {
                  el.selectedIndex = idx;
                  return;
                }
              });
              break;
            case "unit":
              el.options.forEach((opt, idx) => {
                if (opt.value.toLowerCase() === satuan.toLowerCase()) {
                  el.selectedIndex = idx;
                  return;
                }
              });
              break;
          }
        });
        document.getElementById("header-title").textContent = "Edit Bahan";
        bahanAddItem.childNodes[1].action = `bahan/edit/${id}`; // BE ADDING THIS - mengubah url form
      }
      function delSub(subId) {
        Swal.fire({
          title: "Apakah kamu yakin?",
          text: "Sub Bahan yang telah terhapus tidak dapat kembali lagi",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#802302",
          cancelButtonColor: "#6e7d88",
          confirmButtonText: "Ya, hapus",
          cancelButtonText: "Batal",
        }).then(async (result) => {
          if (result.isConfirmed) {
            let response = await fetch("/bahan/delete/" + subId, {
              method: "POST",
            });
            if (response.ok) {
              Swal.fire("Terhapus", "Sub Bahan berhasil terhapus", "success");
            } else {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
              });
            }
          }
        });
      }

      document.getElementById("cancel-add").onclick = () => {
        bahanAllItems.classList.remove("d-none");
        bahanAddItem.classList.remove("d-block");
        window.scrollTo(0, 0);

        document.getElementById("header-title").textContent = "Bahan"; // BE ADDING THIS - mengubah title menjadi Bahan
        bahanAddItem.childNodes[1].action = 'bahan/input'; // BE ADDING THIS - mengubah url form
      };
    </script>
  </body>
</html>
