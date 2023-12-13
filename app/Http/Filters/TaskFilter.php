<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class TaskFilter extends AbstractFilter
{

    const PROJECTS = 'projects';
    const STATUSES = 'statuses';

    protected function getCallbacks(): array
    {
        return [
            self::PROJECTS => [$this, 'projects'],
            self::STATUSES => [$this, 'statuses'],
        ];
    }

    protected function projects(Builder $builder, $value)
    {
        $builder->whereIn('project_id',  $value);
    }

    protected function statuses(Builder $builder, $value)
    {
        $builder->where('status',  $value);
    }
}
