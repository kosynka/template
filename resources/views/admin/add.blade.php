@section('title', 'Создать')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>{{ $type }}</h4>
                </div>
                <div class="col-md-12">
                  <h4>Создать {{ $type }}</h4>
                </div>
                  <div class="table-responsive col-lg-12">
                    @if($errors->any())
                        <div class="alert alert-danger">
                          {{ implode('', $errors->all(':message')) }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{url('admin/'.$model.'/create')}}">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Наименование</label>
                          <input type="text" name="name" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </form>
                  </div>
              </div>
        </div>
    </div>
</section>
@endsection