@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактировать задачу</h1>
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
                <form action="{{route('admin.tasks.update', $task->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Название задачи" name="title"
                               value="{{ $task->title }}"
                        >
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label>Дата выполнения</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" name="deadline"
                                       value="{{ $task->deadline }}">
                                @error('deadline')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Добавить файл</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" value="{{$task->file }}">
                                        <label class="custom-file-label">{{$task->file }}</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Загрузка</span>
                                    </div>
                                </div>
                                @error('file')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Выберите проект</label>
                                <select name="project_id" class="form-control">
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}"
                                                {{ $project->id == $task->project_id ? 'selected' : ''}}
                                        >{{ $project->title }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Выберите исполнителя</label>
                                <select name="performer_id" class="form-control">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == $task->performer_id ? 'selected' : ''}}
                                        >{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('performer_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <input type="submit" class="btn btn-success" value="Редактировать">
                    </div>
                    <div class="mr-4">
                        <a href="{{ route('admin.tasks.show', $task->id) }}" class="btn btn-primary">Назад</a>
                    </div>
                </form>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
