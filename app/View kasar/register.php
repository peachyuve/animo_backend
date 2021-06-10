<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-md-center">

            <div class="col-6">
                <h1>Daftar</h1>
                <?php if (isset($validation)) : ?>
                    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                <?php endif; ?>
                <form action="/register/save" method="post">
                    <div class="mb-3">
                        <label for="InputForName" class="form-label">Nama Bisnis</label>
                        <input type="text" name="businessname" class="form-control" id="InputForName" value="<?= set_value('businessname') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="InputForKota" class="form-label">Kota</label>
                        <input type="text" name="city" class="form-control" id="InputForKota" value="<?= set_value('city') ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </form>
            </div>

        </div>
    </div>


</body>

</html>