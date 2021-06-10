<!DOCTYPE html>
<html lang="id">

<head data-title="Daftar">
  
  <!-- CSS -->
  <link rel="stylesheet" href="source/auth/auth.css">
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  />
</head>

<body class="auth">
    <!-- SIGN UP -->
    <main class="auth__main">
      <div class="auth__bg"></div>
      <div class="auth__card">
        <img src="source/auth/pictures/logo.png" alt="">
        <div class="text-center">
          <h3>Daftar</h3>
          <p id="error"></p>
          <form class="auth__form" id="form" action="/dashboard" method="GET" onsubmit="return validate()">
            <label for="business">
              Nama bisnis
            </label>
            <input  type="text" name="business" id="business">
            <label for="city">
              Kota keberadaan bisnis
            </label>
            <input  type="text" name="city" id="city">
            <button class="button" type="submit" value="submit" id="login">Masuk</button>
          </form>
        </div>
      </div>
    </main>
    

  <!-- JS -->
  <script src="source/auth/js/plugins.js"></script>
  <script type="module" src="source/auth/js/LoginSignUp.js"></script>
  <script>
    
    function validate(){
      let isInputValid = true;
      const errorEl = document.getElementById("error");
      const business = document.getElementById("business");
      const city = document.getElementById("city");
      const elements = []
      elements.push(business,city);
      errorEl.textContent = '';
      elements.forEach(el=>{
        let value = el.value.trim()
        if(value === '' || !value){
          isInputValid = false;
          errorEl.insertAdjacentHTML('afterbegin',el.labels[0].innerText+' wajib diisi<br>')
        }
      })

      if(!isInputValid){
        return false;
      }
      localStorage.setItem("business", business.value);
      return true;
    }
  </script>
</body>

</html>