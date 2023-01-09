@section('title', 'Вид срочности')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Вид срочности</h4>
                </div>
                <div class="col-md-12">
                  <h3>Вид срочности</h3>
                </div>
                  <div class="table-responsive col-lg-12">
                    <div>
                        <a href="{{ url('admin/urgency/add') }}" type="button" class="btn btn-primary" style="margin-bottom: 20px;">Добавить</a>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Название</th>
                            <th scope="col">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($urgencies as $urgency)
                                <tr>
                                    <th scope="row">{{ $urgency->id }}</th>
                                    <td>{{ $urgency->name }}</td>
                                    <td>
                                        <a href="{{ url('admin/urgency/edit/'.$urgency->id) }}" type="button" class="btn btn-warning">Изменить</a>
                                        <a href="{{ url('admin/urgency/delete/'.$urgency->id) }}" type="button" class="btn btn-danger">Удалить</a>
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