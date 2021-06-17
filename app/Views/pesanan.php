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
    <title>Animo | Pesanan</title>
    <?= $this->include('templates/template');?>
    <script defer="defer" src="source/pesanan.961677c8.js"></script>
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
        <section class="pesanan">
          <div id="pesanan-all-items" class="pesanan__all-items w-100">
            <div class="row align-items-center">
              <div class="col-12 col-md-7 mb-5 mb-md-0">
                <div id="add-order" class="add-item">
                  <button class="button-primary button--rounded-1">
                    &plus;
                  </button>
                  <p>Tambah Item</p>
                </div>
              </div>
            </div>
            <div class="row d-relative">
              <table class="table table__bahan">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Status Bayar</th>
                    <th>Status Pesan</th>
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
                      Belum ada pesanan yang ditambahkan.
                    </td>
                  </tr>
                  <?php foreach ($pesanan as $keyPesanan => $valPesanan) { ?>
                  <tr class="align-middle">
                    <!-- inject tanggal dengan format yyy-mm-dd, js yg akan menyempurnakan -->
                    <td data-label="Tanggal"><?= $valPesanan['tglPemesanan'] ?></td>
                    <td data-label="Nama"><?= $valPesanan['namaPemesan'] ?></td>
                    <td data-label="Produk"><?= $valPesanan['produk_nama'] ?></td>
                    <td data-label="Jumlah"><?= $valPesanan['jumlah'] ?></td>
                    <td data-label="Status Bayar"><?= $valPesanan['statusPembayaran'] ?></td>
                    <td data-label="Status Pesan"><?= $valPesanan['statusPemesanan'] ?></td>
                    <td data-label="Aksi">
                      <button
                        onclick="editPesanan({
                        id: '<?= $valPesanan['id'] ?>',
                        tanggal: '<?= $valPesanan['tglPemesanan'] ?>',
                        nama: '<?= $valPesanan['namaPemesan'] ?>',
                        produk: '<?= $valPesanan['produk_nama'] ?>',
                        idProduk : '<?= $valPesanan['idProduk'] ?>', // BE ADDING THIS - mengirim id produk ke form
                        jumlah: '<?= $valPesanan['jumlah'] ?>',
                        statusBayar: '<?= $valPesanan['statusPembayaran'] ?>',
                        statusPesan: '<?= $valPesanan['statusPemesanan'] ?>',
                      })"
                        class="button-primary"
                      >
                        <img src="source/images/pen.svg" alt="Edit Icon" />
                      </button>
                      <button
                        onclick="deletePesanan('<?= $valPesanan['id'] ?>')"
                        class="button-secondary"
                      >
                        <img src="source/images/trash.svg" alt="Delete Icon" />
                      </button>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div id="pesanan-add-item" class="pesanan__add-item w-100 mt-5 p-5">
            <form
              class="form"
              action="/pesanan/input"
              name="form-add-order"
              method="POST"
            >
              <input type="hidden" name="idPesanan" />
              <div
                class="row justify-content-sm-center justify-content-md-start"
              >
                <div class="col-12 col-sm-8 col-md-6 mb-5">
                  <label for="buyer" class="form__label">Nama Pemesan</label>
                  <input
                    type="text"
                    class="form__input"
                    name="buyer"
                    id="buyer"
                  />
                </div>
              </div>
              <div
                class="row justify-content-sm-center justify-content-md-start"
              >
                <div class="col-12 col-sm-8 col-md-6 mb-5">
                  <label class="form__label">Produk yang Dipesan</label>

                  <div class="dropdown__box">
                    <div class="dropdown__options" id="product-options">
                      <?php foreach ($produk as $keyProduk => $valProduk) { ?>
                      <div class="dropdown__option">
                        <input
                          type="radio"
                          id="<?= $valProduk['id'] ?>"
                          name="product"
                          value="<?= $valProduk['nama'] ?>"
                        />
                        <label for="<?= $valProduk['id'] ?>"><?= $valProduk['nama'] ?></label>
                      </div>
                      <?php } ?>
                    </div>
                    <div class="dropdown__selected" id="product-selected"></div>
                  </div>
                </div>
                <div class="col-6 col-sm-8 col-md-4 mb-5">
                  <label for="qty" class="form__label">Jumlah</label>
                  <input
                    type="number"
                    min="0"
                    value="0"
                    class="form__input"
                    name="qty"
                    id="qty"
                  />
                </div>
              </div>
              <input name="idProduk" id="idProduk"/> <!-- BE ADDING THIS - menampung id produk dari dropdown produk -->
              <div
                class="row justify-content-sm-center justify-content-md-start"
              >
                <div class="col-12 col-sm-8 col-md-6 mb-5">
                  <label for="date" class="form__label">Tanggal</label>
                  <input
                    type="date"
                    class="form__input"
                    name="date"
                    id="date"
                  />
                </div>
              </div>
              <div
                class="row justify-content-sm-center justify-content-md-start"
              >
                <div class="col-12 col-sm-8 col-md-6 mb-5">
                  <label class="form__label">Status Pembayaran</label>
                  <div class="d-block d-md-inline-block mb-3">
                    <div class="d-inline-flex align-items-md-center">
                      <label class="form__radio">
                        <input
                          type="radio"
                          name="paymentStatus"
                          value="Belum Lunas"
                          id="payment-opt-1"
                        />
                        <span class="checkmark"></span>
                      </label>
                      <label class="form__radio-label" for="payment-opt-1"
                        >Belum Lunas</label
                      >
                    </div>
                  </div>

                  <div class="d-block d-md-inline-block mb-3">
                    <div class="d-inline-flex align-items-md-center">
                      <label class="form__radio">
                        <input
                          type="radio"
                          name="paymentStatus"
                          value="Lunas"
                          id="payment-opt-2"
                        />

                        <span class="checkmark"></span>
                      </label>
                      <label class="form__radio-label" for="payment-opt-2"
                        >Lunas</label
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="row justify-content-sm-center justify-content-md-start"
              >
                <div class="col-12 col-sm-8 col-md-12 mb-5">
                  <label class="form__label">Status Pesanan</label>
                  <div class="d-block d-md-inline-block mb-3">
                    <div class="d-inline-flex align-items-md-center">
                      <label class="form__radio">
                        <input
                          type="radio"
                          name="orderStatus"
                          value="Sudah Diterima"
                          id="order-opt-1"
                        />
                        <span class="checkmark"></span>
                      </label>
                      <label class="form__radio-label" for="order-opt-1"
                        >Sudah Diterima</label
                      >
                    </div>
                  </div>
                  <div class="d-block d-md-inline-block mb-3">
                    <div class="d-inline-flex align-items-md-center">
                      <label class="form__radio">
                        <input
                          type="radio"
                          name="orderStatus"
                          value="Dibatalkan"
                          id="order-opt-2"
                        />
                        <span class="checkmark"></span>
                      </label>
                      <label class="form__radio-label" for="order-opt-2"
                        >Dibatalkan</label
                      >
                    </div>
                  </div>
                  <div class="d-block d-md-inline-block mb-3">
                    <div class="d-inline-flex align-items-md-center">
                      <label class="form__radio">
                        <input
                          type="radio"
                          name="orderStatus"
                          value="Sedang Diproses"
                          id="order-opt-3"
                        />
                        <span class="checkmark"></span>
                      </label>
                      <label class="form__radio-label" for="order-opt-3"
                        >Sedang Diproses</label
                      >
                    </div>
                  </div>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.js"></script>
    <script>
      const pesananAllItems = document.getElementById("pesanan-all-items");
      const pesananAddItem = document.getElementById("pesanan-add-item");
      const productSelected = document.getElementById("product-selected");
      const productOptions = document.getElementById("product-options");
      const productList = document.querySelectorAll(
        "#product-options .dropdown__option"
      );

      productSelected.onclick = () => {
        productOptions.classList.toggle("active");
      };

      productList.forEach((o) => {
        o.onclick = () => {
          productSelected.textContent = o.querySelector("label").textContent;
          document.getElementById('idProduk').value = o.querySelector("label").htmlFor; // BE ADDING THIS - mengubah value idProduk
          productOptions.classList.remove("active");
        };
      });

      function editPesanan({
        id,
        nama,
        produk,
        idProduk, // BE ADDING THIS - parameter penampung idProduk
        jumlah,
        tanggal,
        statusBayar,
        statusPesan,
      }) {
        pesananAllItems.classList.add("d-none");
        pesananAddItem.classList.add("d-block");
        document.forms["form-add-order"].forEach((el) => {
          switch (el.name) {
            case "idPesanan":
              el.value = id;
              break;
            case "buyer":
              el.value = nama;
              break;
            case "product":
              if (el.value.toLowerCase() === produk.toLowerCase()) {
                el.checked = true;
                productSelected.textContent = el.value;
              }
              break;
            // BE EDIT THIS
            case "idProduk":
              el.value = idProduk;
              break;
            case "qty":
              el.value = jumlah;
              break;
            case "date":
              el.value = tanggal;
              break;
            case "paymentStatus":
              if (el.value.toLowerCase() === statusBayar.toLowerCase()) {
                el.checked = true;
                return;
              }
              break;
            case "orderStatus":
              if (el.value.toLowerCase() === statusPesan.toLowerCase()) {
                el.checked = true;
                return;
              }
              break;
          }
        });
        document.getElementById("header-title").textContent = "Edit Pesanan";
        pesananAddItem.childNodes[1].action = `pesanan/edit/${id}`; // BE ADDING THIS - mengubah url form
      }

      function deletePesanan(orderId) {
        Swal.fire({
          title: "Apakah kamu yakin?",
          text: "Pesanan yang telah terhapus tidak dapat kembali lagi",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#802302",
          cancelButtonColor: "#6e7d88",
          confirmButtonText: "Ya, hapus",
          cancelButtonText: "Batal",
        }).then(async (result) => {
          if (result.isConfirmed) {
            let response = await fetch("/pesanan/delete/" + orderId, {
              method: "POST",
            });
            if (response.ok) {
              Swal.fire("Terhapus", "Pesanan berhasil terhapus", "success");
              setTimeout(() => {
                location.reload();
              }, 2000);
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
        pesananAllItems.classList.remove("d-none");
        pesananAddItem.classList.remove("d-block");
        window.scrollTo(0, 0);

        document.getElementById("header-title").textContent = "Pesanan"; // BE ADDING THIS - mengubah title menjadi Bahan
        pesananAddItem.childNodes[1].action = 'pesanan/input'; // BE ADDING THIS - mengubah url form
      };
    </script>
  </body>
</html>
