@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Задачи</h1>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                                <a href="{{ route('admin.tasks.index') }}" >Все задачи</a>
                                <a href="{{ route('admin.tasks.index', ['status' => 'in_progress']) }}" >В работе</a>
                                <a href="{{ route('admin.tasks.index', ['status' => 'in_review']) }}" >На проверке</a>
                                <a href="{{ route('admin.tasks.index', ['status' => 'completed']) }}" >Выполненные</a>
                            <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary ml-5">Добавить</a>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-wrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Дата Выполнения</th>
                                    <th>Заказчик</th>
                                    <th>Исполнитель</th>
                                    <th>Проект</th>
                                    <th>Статус</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{ $task->id }}</td>
                                        <td><a href="{{ route('admin.tasks.show', $task->id) }}">{{ $task->title }}</a></td>
                                        <td class="text-wrap">{{ $task->formattedDeadline }}</td>
                                        <td class="text-wrap">{{ $task->user->name }}</td>
                                        <td class="text-wrap">{{ $task->performer->name }}</td>
                                        <td class="text-wrap">{{ $task->project->title }}</td>
                                        <td class="text-wrap">{{ $task->getStatus()[$task->status] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
