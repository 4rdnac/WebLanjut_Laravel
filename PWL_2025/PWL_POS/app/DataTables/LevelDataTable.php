<?php

namespace App\DataTables;

use App\Models\LevelModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LevelDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return '<div class="text-end" style="display: flex; justify-content: flex-end; gap: 5px; align-items: center;">
                            <a href="' . route('level.edit', $row->level_id) . '" class="btn btn-warning btn-sm">Ubah</a>
                            <form action="' . route('level.destroy', $row->level_id) . '" method="POST" style="display:inline-block; margin:0;" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>';
            })
            ->rawColumns(['action'])
            ->setRowId('level_id');
    }

    public function query(LevelModel $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('level-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('level_id')->title('Level ID'),
            Column::make('level_kode')->title('Level Kode'),
            Column::make('level_nama')->title('Level Nama'),
            Column::make('created_at')->title('Created At'),
            Column::make('updated_at')->title('Updated At'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-end')
        ];
    }

    protected function filename(): string
    {
        return 'Level_' . date('YmdHis');
    }
}