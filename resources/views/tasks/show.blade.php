@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Задача</h1>
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

                    <!-- /.row --> <div class="mr-4 mb-4">
                        <a href="{{ route('admin.tasks.index') }}" class="btn btn-primary">Назад</a>
                        <div class="card-header d-flex p-3">
                        <form action="{{ route('admin.tasks.review', $task->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="form-group mt-3 mr-4 mb-4">
                                <input type="submit" class="btn btn-warning" value="На проверку">
                            </div>
                        </form>
                        <form action="{{ route('admin.tasks.complete', $task->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="form-group mt-3 mr-4 mb-4">
                                <input type="submit" class="btn btn-success" value="Подтвердить">
                            </div>
                        </form>
                        <form action="{{ route('admin.tasks.work', $task->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="form-group mt-3 mr-4 mb-4">
                                <input type="submit" class="btn btn-danger" value="Отказать">
                            </div>

                        </form>
                        </div>
                    </div>
                    <div class="card">

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
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
                                <tr>
                                    <td>{{ $task->id }}</td>
                                    <td class="text-wrap">{{ $task->title }}</td>
                                    <td class="text-wrap">{{ $task->formattedDeadline }}</td>
                                    <td class="text-wrap">{{ $task->user->name }}</td>
                                    <td class="text-wrap">{{ $task->performer->name }}</td>
                                    <td class="text-wrap">{{ $task->project->title }}</td>
                                    <td class="text-wrap">{{ $task->getStatus()[$task->status] }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card-header d-flex p-3">
                <div class="mr-4">
                    <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-success">Редактировать</a>
                </div>
                <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="task">
                    @csrf
                    @method('delete')
                    <input type="submit" class="btn btn-danger" value="Удалить">
                </form>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
