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
    <title>Animo | Dashboard</title>
    <?= $this->include('templates/template');?>
    <script defer="defer" src="source/dashboard.583b99d9.js"></script>
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
        <div class="row gx-5">
          <div class="col-12 col-md-7 col-xl-7 col-xxl-8">
            <div class="hello">
              <div class="hello__words">
                <!-- change Jason! using php -->
                <h2 class="hello__name">Hello, <span>Jason!</span></h2>
                <h4>Have a nice day at work</h4>
              </div>
              <div class="hello__square">
                <div class="hello__play"></div>
              </div>
              <img
                class="hello__upgrade"
                loading="lazy"
                src="source/images/lets-upgrade.webp"
                alt="Lets Upgrade Features"
              />
            </div>
            <section class="list">
              <h2 class="list__title">Daftar Pesanan</h2>
              <ul class="list__items">
                <?php foreach ($pesanan as $keyPesanan => $valPesanan) { ?>
                <li class="list__item">
                  <img src="https://via.placeholder.com/90" alt="Placeholder" />
                  <div class="list__item-detail">
                    <h3>
                      <?= $valPesanan['nama'] ?> 
                    </h3>
                    <p>Rp. <?= $valPesanan['harga'] ?>/pc x <?= $valPesanan['jumlah'] ?></p>
                  </div>
                </li>
                <?php } ?>
              </ul>
            </section>
            <div class="pager pager--with-space">
              <!-- use DISABLED if the button must not be clicked or just leave it like that -->
              <span class="pager__count"> <?= $pesananDetail['totalItem'] ?> items </span>
              <button>&lt;</button>
              <button>&lt;&lt;</button>
              <span class="pager__current"> <?= $pesananDetail['page'] ?> </span>
              <span class="pager__total">of <?= $pesananDetail['totalPage'] ?> </span>
              <button disabled>&gt;</button>
              <button disabled>&gt;&gt;</button>
            </div>
          </div>
          <div class="col-12 col-md-5 col-xl-5 col-xxl-4">
            <section class="list">
              <h2 class="list__title">Stok Mau Habis</h2>
              <ul class="list__items">
                <?php foreach ($stock as $keyStock => $valStock) { ?>
                <li class="list__item">
                  <img src="https://via.placeholder.com/90" alt="Placeholder" />
                  <div class="list__item-detail">
                    <h3><?= $valStock['nama'] ?></h3>
                    <p><?= $valStock['jumlah'] ?> <?= $valStock['satuan'] ?></p>
                  </div>
                </li>
                <?php } ?>
              </ul>
            </section>
            <div class="level-up">
              <h3 class="level-up__title">Upgrade akun kamu ke premium!</h3>
              <p>
                Nikmati banyak keuntungan yang bikin bisnis kamu makin maksimal.
              </p>
              <a href="/checkout" class="button-primary button--compact"
                >Mulai -></a
              >
              <img src="source/images/level-up.webp" alt="Level Up to Premium" />
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
