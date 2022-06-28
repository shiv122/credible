<?php

namespace App\DataTables;

use App\Models\Business;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BusinessDataTable extends DataTable
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
            ->editColumn('created_at', function ($data) {
                return  date("M jS, Y h:i A", strtotime($data->created_at));
            })
            ->editColumn('name', function ($data) {
                return  '<a target="_blank" href="' . route('admin.users.business.show', $data->id) . '">' . $data->name . '</a>';
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 'active') {
                    $route = route('admin.extra.faq.status');
                    return view('content.table-component.switch', compact('data', 'route'));
                } else {
                    return '<span class="badge badge-danger">NA</span>';
                }
            })
            ->addColumn('action', function ($data) {
                if ($data->status == 'inactive') {
                    return '<btn class="btn btn-flat-success waves-effect waves-float waves-light" onclick="approveBusiness(' . $data->id . ')">Approve</btn>
                    <btn class="btn btn-flat-danger waves-effect waves-float waves-light" onclick="blockBusiness(' . $data->id . ')">Block</btn>';
                } elseif ($data->status == 'active') {
                    return '<btn class="btn btn-flat-danger waves-effect waves-float waves-light" onclick="blockBusiness(' . $data->id . ')">Block</btn>';
                } elseif ($data->status == 'blocked') {
                    return '<btn class="btn btn-flat-success waves-effect waves-float waves-light" onclick="approveBusiness(' . $data->id . ')">Approve</btn>';
                }
            })
            ->escapeColumns('action', 'status');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Business $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Business $model)
    {
        $model =   $model->newQuery();
        if ($this->type) {
            $model->where('status', $this->type);
        }

        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('business-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->parameters([
                'scrollX' => true, 'paging' => true,
                'lengthMenu' => [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
            ])
            ->buttons(
                Button::make('csv'),
                Button::make('excel'),
                Button::make('print'),
                Button::make('pageLength'),
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('type'),
            Column::make('age_of_business'),

            Column::computed('status')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('action')->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Business_' . date('YmdHis');
    }
}
