@section('title', 'Города')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Города</h4>
                </div>
                <div class="col-md-12">
                  <h3>Города</h3>
                </div>
                  <div class="table-responsive col-lg-12">
                    <div>
                        <a href="{{ url('admin/city/add') }}" type="button" class="btn btn-primary" style="margin-bottom: 20px;">Добавить</a>
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
                            @foreach ($cities as $city)
                            <tr>
                                <th scope="row">{{ $city->id }}</th>
                                <td>{{ $city->name }}</td>
                                <td>
                                    <a href="{{ url('admin/city/edit/'.$city->id) }}" type="button" class="btn btn-warning">Изменить</a>
                                    <a href="{{ url('admin/city/delete/'.$city->id) }}" type="button" class="btn btn-danger">Удалить</a>
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