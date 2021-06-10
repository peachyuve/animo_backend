<!DOCTYPE html>
<html lang="id">

<head data-title="Masuk">

  <!-- CSS -->
  <link rel="stylesheet" href="source/auth/auth.css">
  <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
</head>

<body class="auth">
    <!-- Login -->
    <main class="auth__main">
      <div class="auth__bg"></div>
      <div class="auth__card">
        <div class="auth__box">
            <img src="source/auth/pictures/logo.png" alt="">
            <div class="text-center">
              <h3 class="title">Masuk</h3>
              <p id="error"></p>
              <form class="auth__form" id="form" action="index.html" method="GET" onsubmit="return validate()">
                <label for="email">
                  Email
                </label>
                  <input type="text" name="email" id="email">
                <label for="password">
                  Password
                </label>
                  <input type="password" name="password" id="password">
                  <br>
                  <button class="button" type="submit" value="submit" id="login">Masuk</button>
              </form>
              <p style="color: blue; text-decoration:underline; cursor:pointer;" id="how-text" href="#">Bagaimana cara masuk?</p>
            </div>
        </div> 
      </div>
    </main>
    <div class="dialog__backdrop" id="dialog-backdrop"></div>
    <dialog class="dialog__box" id="dialog-how" open>
      <div class="dialog-instructions">
        <svg class="dialog__close" id="dialog-close" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="4em" height="4em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M13.314 11.9l3.535-3.536a1 1 0 1 0-1.414-1.414l-3.536 3.535L8.364 6.95A1 1 0 1 0 6.95 8.364l3.535 3.535l-3.535 3.536a1 1 0 1 0 1.414 1.414l3.535-3.535l3.536 3.535a1 1 0 1 0 1.414-1.414l-3.535-3.536z" fill="#626262"/></svg>
        <h2>Harap ikuti panduan di bawah:</h2>
        <ol>
          <li>Anda harus memiliki akun terlebih dahulu di website Automate All.<br>Kunjungi <a href="https://automateall.id">Automate All</a></li>
          <li>Jika sudah pernah membuat akun di website Automate All, anda dapat menggunakan email & password akun tersebut untuk melakukan Login pada Animo</li>
      </div>
      </ol>
    </dialog>

  <!-- JS -->
  <script src="source/auth/js/plugins.js"></script>
  <script type="module" src="source/auth/js/LoginSignUp.js"></script>
  <script src="source/auth/js/InfoDialog.js"></script>
  <script>
    function validate(){
      let isInputValid = true;
      const errorEl = document.getElementById("error");
      const email = document.getElementById("email");
      const password = document.getElementById("password");
      const elements = []
      elements.push(email,password);
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
      return true;
    }
    const howDialog = new InfoDialog('dialog-how');
    document.getElementById("how-text").addEventListener('click',()=>{
      howDialog.showPopup()
    })
  </script>
</body>

</html>
