@section('title', 'Пользователь')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Пользователь</h4>
                </div>
                <div class="col-md-12">
                    <h4></h4>
                </div>
                <div class="container">
                    <div class="table-responsive col-lg-12">
                        <h3>Пользователь {{ $user->name }}</h3>
                        @if ($user->photo_path)
                            <img class="img rounded text-center" src="{{ url($user->photo_path) }}" style="max-width: 300px">
                            <br><br>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr></tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 25%"><b>Имя: </b></th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Телефон: </b></th>
                                    <td>+7 {{ $user->phone }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Эл.почта: </b></th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Город: </b></th>
                                    @if ($user->city)
                                        <td>{{ $user->city->name }}</td>
                                    @else
                                        <td class="text-warning">Не указан</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th scope="row"><b>Тип бизнеса: </b></th>
                                    @if ($user->business_type)
                                        <td>{{ $user->business_type->name }}</td>
                                    @else
                                        <td class="text-warning">Не указан</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                        <br>

                        <h3>Заявки:</h3>
                        @if (!$user->orders->isEmpty())
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Статус</th>
                                        <th>Комментарий</th>

                                        <th>Исполнитель:</th>
                                        <th>Имя</th>
                                        <th>Город</th>
                                        <th>email</th>
                                        <th>Телефон</th>
                                        <th>Рейтинг</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($user->orders as $order)
                                        <tr>
                                            <th scope="row">{{ $order->id }}</th>
                                            <td>{{ $order->getStatus() }}</td>
                                            <td>{{ $order->comment }}</td>

                                            @if ($order->executor)
                                                <td>
                                                    @if ($order->executor->photo_path)
                                                        <img src="{{ url($order->executor->photo_path) }}" style="max-width: 100px">
                                                    @endif
                                                </td>
                                                <td>{{ $order->executor->name }}</td>
                                                <td>{{ $order->executor->city?->name }}</td>
                                                <td>{{ $order->executor->email }}</td>
                                                <td>{{ $order->executor->phone }}</td>
                                                <td>{{ $order->executor->rating }}</td>
                                                <td>
                                                    <a href="{{ route('details', ['id' => $order->id]) }}" class="btn btn-info">
                                                        Посмотреть заявку
                                                    </a>
                                                </td>
                                            @else
                                                <td>
                                                    Исполнитель еще не выбран
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <a href="{{ route('details', ['id' => $order->id]) }}" class="btn btn-info">
                                                        Посмотреть заявку
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <h4>Отсутствуют заявки</h4>
                            @endif
                        <br>
                        {{-- TODO REVIEWS --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection