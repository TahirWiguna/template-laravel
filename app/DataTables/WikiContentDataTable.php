<?php

namespace App\DataTables;

use App\Helpers\PermissionCommon;
use App\Models\WikiContent;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WikiContentDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))->setRowId('id')->removeColumn('isi');
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WikiContent $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WikiContent $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        $button = [];

        if(PermissionCommon::check('wiki_content.create')) {
            $button[] = Button::raw('<i class="fa fa-plus"></i> Create')->action('function() { create() }');
        }

        if(PermissionCommon::check('wiki_content.delete')) {
            $button[] = Button::raw('<i class="fas fa-trash">')->action('function() { destroy() }');
        }

        if(PermissionCommon::check('wiki_content.update')) {
            $button[] = Button::raw('<i class="fas fa-pen"></i>')->action('function() { update() }');
        }

        if(PermissionCommon::check('wiki_content.show')) {
            $button[] = Button::raw('<i class="fas fa-file-alt"></i>')->action('function() { show() }');
        }

        return $this->builder()
                    ->parameters([
                        'language' => [
                            'search' => '<i class="fas fa-search"></i>',
                            'infoFiltered' => ''
                        ],
                    ])
                    ->setTableId('wiki-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom("<'row'<'col-sm-6'B><'col-sm-3'f><'col-sm-3'l>> <'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>")
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons($button);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('slug'),
            Column::make('judul'),
            // Column::make('isi'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Wiki_' . date('YmdHis');
    }
}
