<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar</title>

    <!-- CSS -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="source/auth/auth.css" />
  </head>

  <body class="auth">
    <!-- SIGN UP -->
    <main class="auth__main">
      <div class="auth__bg"></div>
      <div class="auth__card">
        <img src="source/auth/img/logo.png" alt="Logo Animo" />
        <div class="text-center">
          <h3>Daftar</h3>
          <p id="error"></p>
          <form
            class="auth__form"
            id="form"
            action="dashboard.html"
            method="GET"
            onsubmit="return validate()"
          >
            <label for="business"> Nama bisnis </label>
            <input type="text" name="business" id="business" />
            <label for="city"> Kota keberadaan bisnis </label>
            <input type="text" name="city" id="city" />
            <button class="button" type="submit" value="submit" id="login">
              Masuk
            </button>
          </form>
        </div>
      </div>
    </main>
    <script>
      function validate() {
        let isInputValid = true;
        const errorEl = document.getElementById("error");
        const business = document.getElementById("business");
        const city = document.getElementById("city");
        const elements = [];
        elements.push(business, city);
        errorEl.textContent = "";
        elements.forEach((el) => {
          let value = el.value.trim();
          if (value === "" || !value) {
            isInputValid = false;
            errorEl.insertAdjacentHTML(
              "afterbegin",
              el.labels[0].innerText + " wajib diisi<br>"
            );
          }
        });

        if (!isInputValid) {
          return false;
        }
        localStorage.setItem("business", business.value);
        return true;
      }
    </script>
  </body>
</html>
