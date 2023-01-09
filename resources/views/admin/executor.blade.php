@section('title', 'Исполнители')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Исполнители</h4>
                </div>
                <div class="col-md-12">
                  <h4>Исполнители</h4>
                </div>

                <div class="table-responsive col-lg-12">
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

                    <div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Создать Исполнителя
                        </button>
                    </div><br>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"></th>
                            <th scope="col">Имя</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Город</th>
                            <th scope="col">Дата регистрации</th>
                            <th scope="col">Рейтинг</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($executors as $executor)
                            <tr>
                                <th scope="row">{{ $executor->id }}</th>
                                <td>
                                    @if ($executor->photo_path)
                                        <img src="{{ url($executor->photo_path) }}" style="max-width: 100px">
                                    @endif
                                </td>
                                <td>{{ $executor->name }}</td>
                                <td>+7 {{ $executor->phone }}</td>
                                <td>{{ $executor->email }}</td>
                                @if ($executor->city)
                                    <td>{{ $executor->city->name }}</td>
                                @else
                                    <td class="text-warning">Не указан</td>
                                @endif
                                <td>{{ $executor->created_at }}</td>
                                <td>{{ $executor->rating }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ url('admin/executor', ['id' => $executor->id]) }}">
                                        Детально
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('admin/executor/delete/' . $executor->id) }}" type="button" class="btn btn-danger">
                                        Удалить
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                  </div>
              </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Добавить Исполнителя</h3>
                </div>
                <form class="user" action="{{ url('admin/executor/store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="inputName4">Имя</label>
                                <input type="text" name="name" class="form-control" id="inputName4" placeholder="Боб">
                            </div>
                            <div class="form-group col">
                                <label for="inputEmail4">Эл.почта</label>
                                <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="email@gmail.com">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPhone">Телефон</label>
                            <input type="tel" name="phone" class="form-control" id="inputPhone" placeholder="700 100 2030">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState">Город</label>
                                <select class="select2-single form-control" name="city_id" id="select2Single city_id">
                                    @foreach ($cities as $city)
                                        <option value="{{$city->id}}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputPhotoPath">Фото</label>
                                <input type="file" name="photo_path" class="form-control" id="inputPhotoPath">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword">Пароль</label>
                            <input type="text" name="password" class="form-control" id="inputPassword">
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