@section('title', 'Пользователи')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Пользователи</h4>
                </div>
                <div class="col-md-12">
                  <h4>Пользователи</h4>
                </div>
                  <div class="table-responsive col-lg-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Фото</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Город</th>
                            <th scope="col">Тип бизнеса</th>
                            <th scope="col">Дата регистрации</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>
                                    @if ($user->photo_path)
                                        <img src="{{ url($user->photo_path) }}" style="max-width: 200px">
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>+7 {{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>

                                @if ($user->city)
                                    <td>{{ $user->city->name }}</td>
                                @else
                                    <td class="text-warning">Не указан</td>
                                @endif

                                @if ($user->business_type)
                                    <td>{{ $user->business_type->name }}</td>
                                @else
                                    <td class="text-warning">Не указан</td>
                                @endif
                                
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ url('admin/user', ['id' => $user->id]) }}">
                                        Детально
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('admin/user/delete/'.$user->id) }}" type="button" class="btn btn-danger">
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
</section>
@endsection