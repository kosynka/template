@section('title', 'Админ')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Админ</h4>
                </div>
                <br><br><br>

                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ Session::get('error') }}
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                <div class="col-md-12">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                        Создать Администратора
                    </button>
                </div>

                <br><br>
                <div class="table-responsive col-lg-12">
                    <form class="user" action="{{ url('admin/update') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <h2>Администратор №{{ $admin->id }}</h2>
                        <div class="form-group">
                            <label for="inputUsername">Имя</label>
                            <input type="text" class="form-control" value="{{ $admin->username }}" id="inputUsername" aria-describedby="emailHelp" placeholder="введите имя на латинице" name="username" autocomplete="off" autofocus>
                            <small id="usernameHelp" class="form-text text-muted">Запомните ваши данные и никому их не сообщайте</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Пароль</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="пароль" name="password" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword2">Повторите пароль</label>
                            <input type="password" class="form-control" id="exampleInputPassword2" placeholder="пароль" name="password_confirmation" autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary">Изменить</button>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Добавить Администратора</h3>
                </div>
                <form class="user" action="{{ url('admin/store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputName4">Имя</label>
                            <input type="text" name="username" class="form-control" id="inputName4" placeholder="admin vlad">
                        </div>

                        <div class="form-group">
                            <label for="inputPhone">Пароль</label>
                            <input type="password" name="password" class="form-control" id="inputPhone">
                        </div>

                        <div class="form-group">
                            <label for="inputPassword">Повторите пароль</label>
                            <input type="password" name="password_confirmation" class="form-control" id="inputPassword">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection