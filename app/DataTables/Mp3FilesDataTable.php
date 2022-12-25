<?php

namespace App\DataTables;

use App\Models\Mp3File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class Mp3FilesDataTable extends DataTable
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
                return '<a href="/files/mp3/' . $query->id . '/edit" class="btn btn-primary mb-2" role="button">Edit</a>';
            })
            ->rawColumns(['available', 'action']);
    }

    public function query(Mp3File $model): Builder
    {
        return $model->newQuery();
    }

    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()
            ->setTableId('mp3-files-table')
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
            Column::make('artist'),
            Column::make('album'),
            Column::make('year'),
            Column::make('genre'),
            Column::computed('action')
                ->width(60)
                ->addClass('text-center')
        ];
    }

    protected function filename(): string
    {
        return 'Mp3File_' . date('YmdHis');
    }
}
