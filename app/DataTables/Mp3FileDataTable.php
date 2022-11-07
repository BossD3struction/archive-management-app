<?php
/** @noinspection PhpUnused */

namespace App\DataTables;

use App\Models\Mp3File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class Mp3FileDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
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
                return '<a href="/mp3/files/' . $query->id . '/edit" class="btn btn-primary mb-2" role="button">Edit</a>';
            })
            ->rawColumns(['available', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Mp3File $model
     * @return Builder
     */
    public function query(Mp3File $model): Builder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()
            ->setTableId('mp3-files-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->addTableClass('table-striped w-100')
            //->fixedHeader()
            ->orderBy(1, 'asc');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::computed('available')
                ->width(60)
                ->addClass('text-center'),
            //Column::make('id'),
            //Column::make('filename_path'),
            Column::make('filename'),
            Column::make('title'),
            Column::make('artist'),
            Column::make('album'),
            Column::make('genre'),
            Column::make('year'),
            Column::computed('action')
                ->width(60)
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Mp3File_' . date('YmdHis');
    }
}
