<?php

namespace App\DataTables;

use App\ContactsMessage;
use App\Http\Models\Contact;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use function GuzzleHttp\Psr7\str;

class ContactsMessagesDataTable extends DataTable
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
            ->addColumn('action', 'admin.contact-messages.actionButtons')
            ->editColumn('subject',function ($mails){
                return "<strong>$mails->subject</strong> - " . Str::limit($mails->message,40);
            })->escapeColumns('subject');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\ContactsMessage $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Contact::query();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return data_tables_settings($this,$this->getColumns(),'contact-messages-table');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title('#'),
            Column::make('name')->title('اسم المرسل'),
            Column::make('email')->title('البريد الالكترونى'),
            Column::make('phone')->title('رقم الهاتف'),
            Column::make('subject')->title('عنوان الرسالة - الرسالة'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->title('الحدث')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ContactsMessages_' . date('YmdHis');
    }
}
