<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Панель Админа - Войти</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        html,
        body {
        height: 100%;
        }

        body {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        }

        .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
        }

        .form-signin .checkbox {
        font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
        z-index: 2;
        }

        .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        }
    </style>
</head>
<body class="text-center">
    <main class="form-signin">
        <form action="{{ url('admin/signin') }}" method="POST">
          @if (session('error'))
              <div class="alert alert-danger">
                  {{ session('error') }}
              </div>
          @endif
          <h1 class="h3 mb-3 fw-normal">Добро пожаловать</h1>
          @csrf
      
          <div class="form-floating">
            <input type="text" class="form-control" name="username" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Имя пользователя</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Пароль</label>
          </div>
      
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" name="remember" value="1" checked="0"> Запомнить меня
            </label>
          </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
        </form>
      </main>
</body>
</html>