@section('title', 'Виды бизнеса')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Виды бизнеса</h4>
                </div>
                <div class="col-md-12">
                  <h3>Виды бизнеса</h3>
                </div>
                  <div class="table-responsive col-lg-12">
                    <div>
                        <a href="{{ url('admin/business_type/add') }}" type="button" class="btn btn-primary" style="margin-bottom: 20px;">Добавить</a>
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
                            @foreach ($business_types as $business_type)
                            <tr>
                                <th scope="row">{{ $business_type->id }}</th>
                                <td>{{ $business_type->name }}</td>
                                <td>
                                    <a href="{{ url('admin/business_type/edit/'. $business_type->id) }}" type="button" class="btn btn-warning">Изменить</a>
                                    <a href="{{ url('admin/business_type/delete/'. $business_type->id) }}" type="button" class="btn btn-danger">Удалить</a>
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