<?php

namespace App\DataTables;
use App\Models\KategoriModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
class KategoriDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return '<div class="text-end" style="display: flex; justify-content: flex-end; gap: 5px; align-items: center;">
                        <a href="' . route('kategori.edit', $row->kategori_id) . '" class="btn btn-warning btn-sm">Ubah</a>
                        <form action="' . route('kategori.destroy', $row->kategori_id) . '" method="POST" style="display:inline-block; margin:0;" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>';
            })
            ->rawColumns(['action'])
            ->setRowId('kategori_id');
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(KategoriModel $model): QueryBuilder
    {
        return $model->newQuery();
    }
    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('kategori-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
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
    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
{
    return [
        Column::make('kategori_id')->title('Kategori Id'),
        Column::make('kategori_kode')->title('Kategori Kode'),
        Column::make('kategori_nama')->title('Kategori Nama'),
        Column::make('created_at')->title('Created At'),
        Column::make('updated_at')->title('Updated At'),
        Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(100)
            ->addClass('text-end')
    ];
}


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Kategori_' . date('YmdHis');
    }
}