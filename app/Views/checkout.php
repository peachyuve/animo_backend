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
    <title>Animo | Checkout</title>
    <?= $this->include('templates/template');?>
    <script defer="defer" src="source/checkout.31d6cfe0.js"></script>

  <body>
    <nav class="navbar py-4 navbar-expand navbar-dark">
      <div class="container">
        <a href="./">
        <img
          class="navbar__brand"
          height="452"
          srcset="source/images/logo-beta.webp 737w, source/images/logo-beta@2x.webp 1474w"
          alt="animo beta version logo"
          type="image/webp"
        />
        
        </a>
        <a href="/" class="navbar__text">Kembali</a>
    </nav>
    
    <div class="container">
      <section class="checkout" id="checkout">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-xl-7 mt-5">
              <div class="card" data-section="checkout">
                <div class="card-body">
                  <h2 class="judul-kartu mb-5 op-3">Checkout</h2>
                  <div class="d-flex flex-column align-items-center gap-2">
                    <label class="paket__label">Pilih Paket:</label>
                    <select class="paket__select">
                      <option class="paket__option" value="1" selected>Paket Premium</option>
                    </select>
                  </div>

                  <div class="row text-center justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                      <div data-card="paket"
                        class="card mt-5 text-white"
                      >
                        <div class="card-body">
                          <h5 class="paket__detail-head">Paket Premium</h5>
                          <p class="paket__detail-para">1 Bulan</p>
                          <p class="paket__detail-para">Rp. 25.000</p>
                        </div>
                      </div>
                      <div class="card" data-card="paket-benefit">
                        <div class="card-body">
                          <h3>Keuntungan</h3>
                          <ul>
                            <li>Dapat mengakses semua halaman Animo</li>
                            <li>Fitur Pengingat Stok</li>
                            <li>Fitur Rekap Laporan</li>
                            <li>Berbagai layanan serta produk Automate All</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-xl-5 mt-5">
              <div class="card" data-section="checkout">
                <div class="card-body">
                  <h2 class="judul-kartu mb-5 op-3 text-center">
                    Detil Transaksi
                  </h2>
                  <div class="row px-3 ">
                    <div class="col-6 op-7">
                      <p class="transaksi__data">ID. Pesanan:</p>
                      <p class="transaksi__data">Paket & Durasi:</p>
                      <p class="transaksi__data">Total Bayar:</p>
                    </div>
                    <div class="col-6 text-right op-7">
                      <p class="transaksi__data">12345</p>
                      <p class="transaksi__data">1 bulan</p>
                      <p class="transaksi__data">Rp. 25.000</p>
                    </div>

                    <div class="col-12">
                      <form
                        class="form-bayar"
                        action="/konfirmasiPembayaran"
                        method="POST"
                        enctype="multipart/form-data"
                      >
                        <label class="form-bayar__input-file" for="input-bukti">Upload Bukti Bayar</label>
                        <p class="mt-2 text-center" id="file-name"></p>
                        <input type="file" id="input-bukti" onchange="changeFilename(this)" accept="image/png, image/gif, image/jpeg" name="buktibayar" />

                        <button
                          type="submit"
                          class="
                            btn
                            button-bayar
                            text-white
                            btn-lg btn-block
                            mt-4
                            mb-3
                            rounded-pill
                          "
                        >
                          Konfirmasi Pembayaran
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-end mt-5">
            <div class="col-md-6 col-xl-5">
              <div class="card text-center" data-section="checkout" data-section-name="checkout-metode">
                <div class="card-body P-3">
                  <h2 class="judul-kartu mb-5 op-3">Metode Pembayaran</h2>
                  <img
                    class="img-fluid mt-1"
                    src="source/images/pembayaran.png"
                    alt="Metode Pembayaran"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <script>
      function changeFilename(input){
        const fileName = input.files[0]?.name;
        document.getElementById("file-name").textContent = fileName || 'Klik tombol kembali';
      }
    </script>
  </body>
</html>
