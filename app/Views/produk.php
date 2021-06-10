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
    <title>Animo | Produk</title>

    <?= $this->include('templates/template');?>
    <script defer="defer" src="source/produk.2c84c619.js"></script>
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
        <div class="row mb-5">
          <div class="col-12 col-sm-8 col-md-6 col-lg-6 order-2 order-lg-1 mx-auto ml-lg-0">
            <div class="filter">
              <p class="filter__label">Kategori Produk</p>
              <button
                class="filter__toggler"
                id="filter-toggler"
                aria-expanded="false"
              >
                <h4> <?= $selectedKategori ?> </h4>
                <span>&gt;</span>
              </button>
              <ul id="filter-group" class="filter__group">
                <?php foreach ($kategori as $keyKategori => $valKategori) { ?>
                <li class="filter__value">
                  <a href="?kategori=<?= $valKategori ?>">
                    <h4><?= $valKategori ?></h4>
                  </a>
                </li>
                <?php } ?>
                <li data-modal="add-prod-cat" class="filter__add">
                  + Tambah Kategori
                </li>
              </ul>
            </div>
            <ul class="products">
              <!-- pindahkan class "products__item--selected" ke item atau produk yang sedang dipilih oleh user, agar nanti item terpilih ada backgroundnya di UI -->
              <?php foreach ($produk as $keyProduk => $valProduk) { ?>
              <li class="products__item product<?= ($valProduk['isSelected'])?'s':'' ?>__item--selected">
                  <a href="?kategori=<?= $valProduk['nama_kategori'] ?>&produk=<?= $valProduk['id'] ?>">
                    <h4>
                      <?= $valProduk['nama'] ?>
                    </h4>
                  </a>
                </li>
              <?php } ?>
            </ul>
            <div data-modal="add-product" class="add-item">
              <button class="button-primary button--rounded-1">&plus;</button>
              <p>Tambah Produk</p>
            </div>
          </div>
          <div class="col-12 col-lg-6 order-1 order-lg-2 mb-5">
            <div class="product-detail">
              <!-- ubah dengan data produk yang sedang dipilih user -->
              <div
                style="
                  background-image: url(https://2.bp.blogspot.com/-ONWkgAXHXE8/UQvKC0INcqI/AAAAAAAAAPU/CEZDoV6YA3c/s1600/far-cry3x-large.jpg);
                  background-position: center;
                  background-size: cover;
                "
                class="product-detail__image"
              />
              </div>
              <div class="product-detail__desc">
                <div class="d-flex align-items-center">
                  <h2 class="product-detail__name">
                    <?= $selectedProduk['nama'] ?>
                  </h2>
                  <button data-modal="edit-product" class="button-primary">
                    <img src="source/images/pen.svg" alt="Edit Icon" />
                  </button>
                </div>
                <p class="text-center mt-1 mt-lg-4"><?= $selectedProduk['ukuran'] ?> <?= $selectedProduk['satuan'] ?></p>
                <!-- just inject the number, js will convert that number to rupiah format -->
                <p id="product-price" class="text-center"><?= $selectedProduk['harga'] ?></p>
              </div>
              <div class="product-material">
                <div class="d-flex align-items-center justify-content-center">
                  <h2 class="product-material__title">
                    Bahan Produk
                  </h2>
                  <!-- query di bawah bertujuan untuk memfilter langsug berdasarkan produk setelah user diredirect ke laman Resep -->
                  <a href="./resep.html?produk=PRODwf157" class="button-primary"
                    >&plus;</a
                  >
                </div>
                <!-- Ubah dengan data bahan yang diperlukan dalam  membuat produk ini -->
                <table class="product-material__table" >
                  <thead>
                    <tr>
                      <th>Nama Bahan  </th>
                      <th>Jumlah</th>
                      <th>Satuan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Gula Manis Asin Asem Asin Asem Asin Manis</td>
                      <td>250</td>
                      <td>gr</td>
                    </tr>
                    <tr>
                      <td>Tepung</td>
                      <td>100</td>
                      <td>gr</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </main>

      <!-- POPUP TAMBAH PRODUCT -->
      <dialog class="dialog dialog__add-product" id="add-product" open>
        <div class="dialog__backdrop">
          <div class="dialog__box">
            <!-- feedback messages will be shown here (UI feedback secara default tidak tampil, js lah yang akan menampilkan bila ada validasi yang gagal) -->
            <div id="add-product-feedback" class="dialog__feedback">
              <ul class="dialog__feedback-msg"></ul>
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" data-id="backToForm" viewBox="0 0 16 16">
                <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z"/>
              </svg>
            </div>
            <form
              action="/produk/save"
              method="POST"
              id="form-add-product"
              enctype="multipart/form-data"
            >
              <input
                id="prod-kategori"
                type="hidden"
                name="category"
                value="<?= $selectedKategori ?>"
              />
              <div class="upload-image">
                <input
                  type="file"
                  id="prod-image"
                  name="image"
                  accept="image/*"
                />
                <label
                  id="upload-area"
                  class="upload-image__area"
                  for="prod-image"
                  >&plus;</label
                >
                <p class="text-center mt-3">Tambah Foto Produk</p>
              </div>
              <div class="form-group">
                <label class="form-label" for="product-name">Nama Produk</label>
                <input
                  id="prod-name"
                  type="text"
                  name="product"
                  value=""
                  placeholder="Nama"
                />
              </div>
              <div class="form-group">
                <label class="form-label" for="product-size">Ukuran</label>
                <div class="d-flex gap-2">
                  <input
                    id="prod-size"
                    type="number"
                    name="size"
                    placeholder="Ukuran"
                    value="1"
                    min="0"
                  />
                  <input
                    style="width: 10rem;"
                    id="prod-unit"
                    type="text"
                    value="gr"
                    name="unit"
                    placeholder="Satuan"
                  />
                </div>
              </div>
              <div class="form-group">
                <label class="form-label" for="product-price">Harga (Rp)</label>
                <input
                  id="prod-price"
                  type="number"
                  step="10000"
                  name="price"
                  value="10000"
                  min="0"
                  placeholder="harga"
                />
              </div>
              <div class="dialog__cta">
                <button type="button" class="cancel-form button-secondary">Batal</button>
                <button class="button-primary" type="submit">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </dialog>

      <!-- POPUP TAMBAH KATEGORI PRODUCT -->
      <dialog class="dialog dialog__add-prod-cat" id="add-prod-cat" open>
        <div class="dialog__backdrop">
          <div class="dialog__box">
            <form id="form-add-prod-cat" action="" method="POST">
              <input
                type="text"
                id="prod-cat"
                name="category"
                placeholder="Masukkan Nama Kategori"
              />
              <div class="dialog__prompt">
                <span>Tekan <strong>Enter</strong> atau 
              </span>
                <button class="button-primary" id="prod-cat-save" disabled="true">Tambah</button>
              </div>
            </form>
          </div>
        </div>
      </dialog>

      <!-- POPUP EDIT PRODUCT -->
      <!-- Ubah semua value pada tiap input dengan php berdasarkan produk id yang sedang dipilih user -->
      <dialog class="dialog dialog__add-product" id="edit-product" open>
        <div class="dialog__backdrop">
          <div class="dialog__box">
            <!-- feedback messages will be shown here (UI feedback secara default tidak tampil, js lah yang akan menampilkan bila ada validasi yang gagal) -->
            <div id="edit-product-feedback" class="dialog__feedback">
              <ul class="dialog__feedback-msg"></ul>
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" data-id="backToForm" viewBox="0 0 16 16">
                <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z"/>
              </svg>
            </div>
            <form
              action="/produk/update/<?= $selectedProduk['id'] ?>"
              method="POST"
              id="form-edit-product"
              enctype="multipart/form-data"
            >
              <!-- Beri value pada input ini dengan id product agar di dalam POST terdapat id productnya -->
              <input
                id="prod-id"
                type="hidden"
                name="product-id"
                value="cookies123"
              />

              <div class="upload-image">
                <input
                  type="file"
                  id="prod-image-edit"
                  name="image"
                  accept="image/*"
                />
                <!-- ubah url pada background di bawah menyesuaikan url gambar produknya, ini hanya sekedar preview -->
                <label
                  style="
                    background-image: url('https://2.bp.blogspot.com/-ONWkgAXHXE8/UQvKC0INcqI/AAAAAAAAAPU/CEZDoV6YA3c/s1600/far-cry3x-large.jpg');
                    background-size: cover;
                    background-position: center;
                  "
                  id="upload-area-edit"
                  class="upload-image__area"
                  for="prod-image-edit"
                ></label>
                <!-- ubah dengan nama file nya -->
                <p class="mt-3 text-center">doctor.jpeg</p>
              </div>
              <div class="form-group">
                <label class="form-label" for="product-name-edit"
                  >Nama Produk</label
                >
                <input
                  id="prod-name-edit"
                  type="text"
                  name="product"
                  value="<?= $selectedProduk['nama'] ?>"
                  placeholder="Nama"
                />
              </div>
              <div class="form-group">
                <label class="form-label" for="product-size-edit">Ukuran</label>
                <div class="d-flex gap-2">
                  <input
                    id="prod-size-edit"
                    type="number"
                    name="size"
                    value="<?= $selectedProduk['ukuran'] ?>"
                    placeholder="Ukuran"
                    min="0"
                  />
                  <input
                    id="prod-unit-edit"
                    style="width: 10rem;"
                    type="text"
                    name="unit"
                    value="<?= $selectedProduk['satuan'] ?>"
                    placeholder="Satuan"
                  />

                </div>
              </div>
              <div class="form-group">
                <label class="form-label" for="product-price-edit"
                  >Harga (Rp)</label
                >
                <input
                  id="prod-price-edit"
                  type="number"
                  step="10000"
                  name="price"
                  value="<?= $selectedProduk['harga'] ?>"
                  min="0"
                  placeholder="harga"
                />
              </div>
              <div class="dialog__cta">
                <button type="button" class="cancel-form button-secondary ">Batal</button>
                <button class="button-primary" type="submit">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </dialog>
    </div>
  </body>
</html>
