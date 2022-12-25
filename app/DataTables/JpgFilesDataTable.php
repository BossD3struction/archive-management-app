<?php

namespace App\DataTables;

use App\Models\JpgFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JpgFilesDataTable extends DataTable
{
    public function dataTable($query): DataTableAbstract
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('available', function ($query) {
                if (File::exists($query->filename_path)) {
                    return '<h4><i class="bi bi-check-square"></i></h4>';
                } else {
                    return '<h4><i class="bi bi-x-square"></i></i></h4>';
                }
            })
            ->addColumn('action', function ($query) {
                return '<a href="/files/jpg/' . $query->id . '/edit" class="btn btn-primary mb-2" role="button">Edit</a>';
            })
            ->rawColumns(['available', 'action']);
    }

    public function query(JpgFile $model): Builder
    {
        return $model->newQuery();
    }

    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()
            ->setTableId('jpg-files-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->addTableClass('table-striped w-100')
            ->orderBy(1, 'asc');
    }

    protected function getColumns(): array
    {
        return [
            Column::computed('available')
                ->width(60)
                ->addClass('text-center'),
            Column::make('filename'),
            Column::make('title'),
            Column::make('tags'),
            Column::make('comments'),
            Column::make('date')->title('Date Taken'),
            Column::computed('action')
                ->width(60)
                ->addClass('text-center')
        ];
    }

    protected function filename(): string
    {
        return 'JpgFiles_' . date('YmdHis');
    }
}
