@section('title', 'Заявка')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Заявки</h4>
                </div>
                <div class="col-md-12">
                    <h4></h4>
                </div>
                <div class="container">
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

                        <h3>Заявка №{{ $order->id }}</h3>
                        @if ($order->image_path)
                            @for ($i = 0; $i < count($order->image_path); $i++)
                                <img src="{{ url($order->image_path[$i]) }}" style="max-width: 600px" class="rounded mx-auto m-3">
                            @endfor
                        @endif
                        <br><br>

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr></tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 25%"><b>Имя создавшего пользователя: </b></th>
                                    @if ($order->user)
                                        <td>{{ $order->user->name }}</td>
                                    @else
                                        <td class="text-warning">Пользователь удален</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th scope="row"><b>Город: </b></th>
                                    @if ($order->city)
                                        <td>{{ $order->city->name }}</td>
                                    @else
                                        <td class="text-warning">Не указан</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th scope="row"><b>Адрес: </b></th>
                                    <td>{{ $order->address }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Дата начала проведения работ: </b></th>
                                    <td>{{ $order->works_date }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Комментарий: </b></th>
                                    <td>{{ $order->comment }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Статус: </b></th>
                                    <td>{{ $order->getStatus() }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Срочность: </b></th>
                                    @if ($order->urgency)
                                        <td>{{ $order->urgency->name }}</td>
                                    @else
                                        <td class="text-warning">Не указан</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th scope="row"><b>Создан: </b></th>
                                    <td>{{ $order->created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>

                        @if ($order->files)
                            <h4>Файлы:</h4>

                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr></tr>
                                </thead>
    
                                <tbody>
                                    @for ($i = 0; $i < count($order->files); $i++)
                                        <tr>
                                            <th scope="row"><b>{{ $i+1 }}</b></th>
                                            <td>
                                                <a href="{{ url($order->files[$i]['file_path']) }}" download="заявка_{{$order->id}}_вложенный_файл_{{$order->files[$i]['id']}}">
                                                    скачать файл
                                                </a>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        @endif
                        <br><br>

                        <h3>Предложения:</h3>
                        @if (!$order->offers->isEmpty())
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
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($order->offers as $offer)
                                        <tr>
                                            <th scope="row">{{ $offer->id }}</th>
                                            @if ($offer->getStatus() == 'Создан')
                                                <td>{{ $offer->getStatus() }}</td>
                                            @else
                                                @if ($offer->getStatus() == 'Принят')
                                                    <td class="text-success">{{ $offer->getStatus() }}</td>
                                                @else
                                                    <td class="text-danger">{{ $offer->getStatus() }}</td>
                                                @endif
                                            @endif
                                            <td>{{ $offer->comment }}</td>

                                            @if ($offer->executor)
                                                <td>
                                                    @if ($offer->executor->photo_path)
                                                        <img src="{{ url($offer->executor->photo_path) }}" style="max-width: 100px">
                                                    @endif
                                                </td>
                                                <td>{{ $offer->executor->name }}</td>
                                                @if ($offer->executor->city)
                                                    <td>{{ $offer->executor->city->name }}</td>
                                                @else
                                                    <td class="text-warning">Не указан</td>
                                                @endif
                                                <td>{{ $offer->executor->email }}</td>
                                                <td>{{ $offer->executor->phone }}</td>
                                                <td>{{ $offer->executor->rating }}</td>
                                                @if ($offer->getStatus() == 'Создан')
                                                    <td>
                                                        <a href="{{ url('admin/accept/offer', ['id' => $offer->id]) }}" class="btn btn-success">
                                                            Принять
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('admin/decline/offer', ['id' => $offer->id]) }}" class="btn btn-danger">
                                                            Отклонить
                                                        </a>
                                                    </td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                
                                            @else
                                                <td class="text-warning">
                                                    Исполнитель удален
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
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
                            <h4>Отсутствуют предложения</h4>
                        @endif
                        <br>

                        <h3>Исполнитель:</h3>
                        @isset ($order->executor)
                            @if ($order->executor->photo_path)
                                <img class="img rounded text-center" src="{{ url($order->executor->photo_path) }}" style="max-width: 300px">
                                <br><br>
                            @endif
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr></tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 25%"><b>Имя: </b></th>
                                        <td>{{ $order->executor->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><b>Телефон: </b></th>
                                        <td>+7 {{ $order->executor->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><b>Эл.почта: </b></th>
                                        <td>{{ $order->executor->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><b>Город: </b></th>
                                        @if ($order->executor->city)
                                            <td>{{ $order->executor->city->name }}</td>
                                        @else
                                            <td class="text-warning">Не указан</td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <h4>Исполнитель еще не выбран или был удален</h4>
                        @endisset

                        <p>
                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Выбрать Исполнителя
                            </a>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <form class="user" action="{{ url('admin/update/' . $order->id) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                        <select class="select2-single form-control" name="executor_id" id="select2Single city_id">
                                            @foreach ($executors as $executor)
                                                <option value="{{$executor->id}}">{{ $executor->id }} - {{ $executor->name }}</option>
                                            @endforeach
                                        </select><br>

                                        <button type="submit" class="btn btn-info">
                                            <i class="fa fa-check" aria-hidden="true"></i> Выбрать
                                        </button>
                            </form>
                        </div>

                        <br>

                        <h3>Отчеты работы:</h3>
                        @if ($order->reports->isNotEmpty())
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr></tr>
                                </thead>

                                <tbody>
                                    @foreach ($order->reports as $report)
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
                                        @if ($order->status == 'REPORT_SENT' && $report->type == "report_after")
                                            <td scope="row">
                                                <a href="{{ url('admin/accept/report', ['id' => $order->id]) }}" class="btn btn-success">
                                                    Принять Отчет
                                                </a>
                                                <br><br>
                                                <a href="{{ url('admin/decline/report', ['id' => $order->id]) }}" class="btn btn-danger">
                                                    Отклонить Отчет
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4>Отсутствует отчет</h4>
                        @endisset
                        <br><br>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection