@section('title', 'Отклики')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Отклики</h4>
                </div>
                <div class="col-md-12">
                  <h4>Отклики</h4>
                </div>
                  <div class="table-responsive col-lg-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Комментарий</th>
                            <th scope="col">Исполнитель</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Дата создания</th>
                            <th scope="col">№ заявки</th>
                            <th scope="col">Комментарий</th>
                            <th scope="col">Срочность</th>
                            <th scope="col">Пользователь</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($offers as $offer)
                                <tr>
                                    <th scope="row">{{ $offer->id }}</th>
                                    <td>{{ $offer?->comment }}</td>
                                    @if ($offer->executor)
                                        <td>{{ $offer->executor->name }}</td>
                                    @else
                                        <td class="text-warning">Исполнитель удален</td>
                                    @endif
                                    <td>
                                        @if ($offer->status == "ACCEPTED")
                                            <a class="text-success">{{ $offer->getStatus() }}</a>
                                        @else
                                            <a class="text-danger">{{ $offer->getStatus() }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $offer->created_at }}</td>
                                    <td>{{ $offer->order?->id }}</td>
                                    <td>{{ $offer->order?->comment }}</td>
                                    @if ($offer->order?->urgency)
                                        <td>{{ $offer->order?->urgency->name }}</td>
                                    @else
                                        <td class="text-warning">Не указан</td>
                                    @endif
                                    @if ($offer->order?->user)
                                        <td>{{ $offer->order->user->name }}</td>
                                    @else
                                        <td class="text-warning">Пользователь удален</td>
                                    @endif
                                    <td>
                                        <a class="btn btn-default" href="{{ route('details', ['id' => $offer->order?->id]) }}">посмотреть заявку</a>
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