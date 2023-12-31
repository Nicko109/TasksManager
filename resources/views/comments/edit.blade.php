@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактировать комментарий</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Главная</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-6 col-12">
                    <form action="{{route('admin.comments.update', $comment->id)}}" method="post">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Комментарий" name="body"  value="{{ $comment->body }}">
                            @error('body')
                            <div class="text-danger">Это поле необходимо для заполнения</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Выберите исполнителя</label>
                            <select name="task_id" class="form-control">
                                @foreach($tasks as $task)
                                    <option value="{{ $task->id }}"
                                        {{ $task->id == $comment->task_id ? 'selected' : ''}}
                                    >{{ $task->title }}</option>
                                @endforeach
                            </select>
                            @error('task_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <input type="submit" class="btn btn-success" value="Редактировать">
                        </div>
                        <div class="mr-4">
                            <a href="{{ route('admin.comments.show', $comment->id) }}" class="btn btn-primary">Назад</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
