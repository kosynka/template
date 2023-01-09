@section('title', 'Заявки')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Заявки</h4>
                </div>
                <div class="col-md-12">
                  <h4>Заявки</h4>
                </div>
                <div class="table-responsive col-lg-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Пользователь</th>
                            <th scope="col">Исполнитель</th>
                            <th scope="col">Город</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">Фото заявки</th>
                            <th scope="col">Дата начала проведения работ</th>
                            <th scope="col">Комментарий</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Срочность</th>
                            <th scope="col">Создан</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <th scope="row">{{ $order->id }}</th>

                                    @if ($order->user)
                                        <td>{{ $order->user->name }}</td>
                                    @else
                                        <td class="text-warning">Пользователь удален</td>
                                    @endif

                                    @if ($order->executor)
                                        <td>{{ $order->executor->name }}</td>
                                    @else
                                        <td class="text-warning">Исполнитель удален или не выбран</td>
                                    @endif

                                    @if ($order->city)
                                        <td>{{ $order->city->name }}</td>
                                    @else
                                        <td class="text-warning">Не указан</td>
                                    @endif

                                    <td>{{ $order->address }}</td>
                                    <td>
                                        @if ($order->image_path)
                                            @for ($i = 0; $i < count($order->image_path); $i++)
                                                <img src="{{ url($order->image_path[$i]) }}" style="max-width: 200px" class="rounded mx-auto m-3">
                                            @endfor
                                        @endif
                                    </td>
                                    <td>{{ $order->works_date }}</td>
                                    <td>{{ $order->comment }}</td>

                                    @if ($order->getStatus() == 'APPROVED')
                                        <td class="text-success">{{ $order->getStatus() }}</td>
                                    @else
                                        <td class="text-secondary">{{ $order->getStatus() }}</td>
                                    @endif
                                    
                                    @if ($order->urgency)
                                        <td>{{ $order->urgency->name }}</td>
                                    @else
                                        <td class="text-warning">Не указан</td>
                                    @endif
                                    
                                    <td>{{ $order->created_at }}</td>
                                    <td>
                                        <a href="{{ route('details', ['id' => $order->id]) }}" class="btn btn-info">
                                            Детально
                                        </a>
                                    </td>
                                    {{-- <td>
                                        <a href="{{ url('admin/delete/'.$order->id) }}" type="button" class="btn btn-danger">
                                            Удалить
                                        </a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-8">
                          <nav>
                            <ul class="pagination">
                              {{$orders->links()}}
                            </ul>
                          </nav>
                        </div>
                    </div>
                  </div>
              </div>
        </div>
    </div>
</section>
@endsection