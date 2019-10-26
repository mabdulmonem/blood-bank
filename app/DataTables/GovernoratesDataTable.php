<?php

namespace App\DataTables;

use App\Http\Models\Governorate;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GovernoratesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', 'admin.governorates.actionButtons');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Governorate $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Governorate::query();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return data_tables_settings($this,$this->getColumns(),'governorates-table');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title("#"),
            Column::make('name')->title('اسم المحافظة'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->title('الحدث'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Governorates_' . date('YmdHis');
    }
}
