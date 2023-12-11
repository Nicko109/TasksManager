@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Добавить задачу</h1>
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
                    <form action="{{route('admin.tasks.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group w-50">
                            <label for="title">Добавить название</label>
                            <input type="text" class="form-control" placeholder="Название задачи" name="title"
                                   id="title"
                                   value="{{ old('title') }}"
                            >
                            @error('title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Время выполнения</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" name="deadline"
                                       value="{{ old('deadline') }}">
                            </div>
                            @error('deadline')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Добавить файл</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Выберите файл</label>
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
                                            {{ $project->id == old('project_id') ? 'selected' : ''}}
                                    >{{ $project->title }}</option>
                                @endforeach
                            </select>
                            @error('project_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Выберите исполнителя</label>
                            <select name="performer_id" class="form-control">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            {{ $user->id == old('performer_id') ? 'selected' : ''}}
                                    >{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('performer_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <input type="submit" class="btn btn-primary" value="Добавить">
                        </div>
                        <div class="mr-4">
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-primary">Назад</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
