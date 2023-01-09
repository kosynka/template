@section('title', 'Исполнитель')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Исполнитель</h4>
                </div>
                <div class="col-md-12">
                    <h4></h4>
                </div>
                <div class="container">
                    <div class="table-responsive col-lg-12">
                        <h3>Исполнитель {{ $executor->name }}</h3>
                        @if ($executor->photo_path)
                            <img class="img rounded text-center" src="{{ url($executor->photo_path) }}" style="max-width: 300px">
                            <br><br>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr></tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 25%"><b>Имя: </b></th>
                                    <td>{{ $executor->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Телефон: </b></th>
                                    <td>+7 {{ $executor->phone }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Эл.почта: </b></th>
                                    <td>{{ $executor->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Город: </b></th>
                                    @if ($executor->city)
                                        <td>{{ $executor->city->name }}</td>
                                    @else
                                        <td class="text-warning">Не указан</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                        <br>

                        <h3>Сделанные работы:</h3>
                        @if ($executor->orders->isNotEmpty())
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>№ заявки</th>
                                        <td>Имя создавшего пользователя:</td>
                                        <td>Город</td>
                                        <td>Комментарий</td>
                                        <td>Статус заявки</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($executor->orders as $order)
                                        @if ($order->status == "APPROVED")
                                            <tr>
                                                <th scope="row">{{ $order->id }}</th>
                                                @if ($order->user)
                                                    <td>{{ $order->user->name }}</td>
                                                @else
                                                    <td class="text-warning">Не указан</td>
                                                @endif

                                                @if ($order->city)
                                                    <td>{{ $order->city->name }}</td>
                                                @else
                                                    <td class="text-warning">Не указан</td>
                                                @endif

                                                <td>{{ $order->comment }}</td>
                                                <td>{{ $order->getStatus() }}</td>
                                                @if ($order->photo_path)
                                                    <td>
                                                        <img class="img rounded text-center" src="{{ url($order->photo_path) }}" style="max-width: 300px">
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('details', ['id' => $order->id]) }}" class="btn btn-info">
                                                        Посмотреть заявку
                                                    </a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <th scope="row" class="text-warning">Исполнитель не имеет подтвержденных заявок</th>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4>Исполнитель не начал подавать предложения на заявки</h4>
                        @endisset
                        <br>

                        <h3>Предложения на заявки:</h3>
                        @if (!$executor->offers->isEmpty())
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Статус</th>
                                        <th>Комментарий</th>
                                        <th>№ Заявки</th>
                                        <th>Комментарий заявки</th>
                                        <th>Статус</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($executor->offers as $offer)
                                        <tr>
                                            <th scope="row">{{ $offer->id }}</th>
                                            
                                            @if ($offer->getStatus() == 'Принят')
                                                <td class="text-success">{{ $offer->getStatus() }}</td>
                                            @else
                                                <td class="text-secondary">{{ $offer->getStatus() }}</td>
                                            @endif

                                            <td>{{ $offer->comment }}</td>

                                            @if (isset($offer->order))
                                                <td>{{ $offer->order->id }}</td>
                                                <td>{{ $offer->order->comment }}</td>
                                                <td>{{ $offer->order->getStatus() }}</td>
                                                @if ($offer->order->photo_path)
                                                    <td>
                                                        <img class="img rounded text-center" src="{{ url($offer->order->photo_path) }}" style="max-width: 300px">
                                                    </td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('details', ['id' => $offer->order?->id]) }}" class="btn btn-info">
                                                        Посмотреть заявку
                                                    </a>
                                                </td>
                                            @else
                                                <td>Владелец заявки был удален</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4>Исполнитель еще не кидал предложения</h4>
                        @endif
                        <br>

                        <h3>Отчеты:</h3>
                        @if ($executor->reports->isNotEmpty())
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <td>Тип</td>
                                        <td>Комментарий</td>
                                        <td>Изображения</td>
                                        <td>№ заявки</td>
                                        <td>Статус заявки</td>
                                        <td></td>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($executor->reports as $report)
                                    <tr>
                                        <th scope="row">{{ $report->id }}</th>
                                        @if ($report->type == "report_before")
                                            <td>Отчет ДО</td>
                                        @else
                                            <td>Отчет ПОСЛЕ</td>
                                        @endif
                                        <td>{{ $report->comment }}</td>
                                        <td>
                                            @for ($i = 0; $i < count($report->image_path); $i++)
                                                <img src="{{ url($report->image_path[$i]) }}" style="max-width: 200px" class="rounded mx-auto m-3">
                                            @endfor
                                        </td>
                                        @if (isset($report->order))
                                            <td>{{ $report->order->id }}</td>
                                            <td>
                                                <a href="{{ route('details', ['id' => $report->order->id]) }}" class="btn btn-info">
                                                    Посмотреть заявку
                                                </a>
                                            </td>
                                        @else
                                            <td>Заявка была удалена</td>
                                            <td></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4>Отсутствуют отчеты</h4>
                        @endisset
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection