<!DOCTYPE html>
<html lang="id">

<head data-title="Daftar">
  
  <!-- CSS -->
  <link rel="stylesheet" href="css/fonts.css">
  <link rel="stylesheet" href="css/main.built.css">
  <script defer="defer" src="./js/modules/InitialInject.js"></script>
</head>

<body class="auth">
    <!-- SIGN UP -->
    <main class="auth__main">
      <div class="auth__bg"></div>
      <div class="auth__card">
        <div class="auth__box">
          <img src="/img/pictures/logo.png" alt="">
          <div class="text-center">
            <h3>Daftar</h3>
            <form action="" class="auth__form" id="form" method="post">
            </form> <!-- harus ada biar bisa input -->
            <form action="/register/save" class="auth__form" id="form" method="post">
              <label for="business">
                Nama bisnis
              </label>
              <input  type="text" name="business" id="business" value="<?= old('business') ?>">
              <label for="city">
                Kota keberadaan bisnis
              </label>
              <input  type="text" name="city" id="city" value="<?= old('city') ?>">
              <label for="username">
                Username
              </label>
              <input  type="text" name="username" id="username">
              <label for="password">
                Password
              </label>
              <input  type="password" name="password" id="password">
              <br>
              <button class="button" type="submit">Masuk</button>
                <!-- <a href="dashboard.html">Go to
                  Dashboard</a> -->
            </form>
          </div>
        </div>
      </div>
    </main>
    

  <!-- JS -->
  <script src="js/plugins.js"></script>
  <script type="module" src="js/LoginSignUp.js"></script>
</body>

</html>
