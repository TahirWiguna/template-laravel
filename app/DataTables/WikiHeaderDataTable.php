<?php

namespace App\DataTables;

use App\Helpers\PermissionCommon;
use App\Models\WikiHeader;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WikiHeaderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))->setRowId('id');
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WikiHeader $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WikiHeader $model): QueryBuilder
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
        
        if(PermissionCommon::check('wiki_header.create')) {
            $button[] = Button::raw('<i class="fa fa-plus"></i> Create')->action('function() { window.location.href = "'.route('wiki_header.create').'" }');
        }

        if(PermissionCommon::check('wiki_header.delete')) {
            $button[] = Button::raw('<i class="fas fa-trash">')->action('function() { destroy() }');
        }

        if(PermissionCommon::check('wiki_header.update')) {
            $button[] = Button::raw('<i class="fas fa-pen"></i>')->action('function() { update() }');
        }

                
        if(PermissionCommon::check('wiki_content.list')) {
            $button[] = Button::raw('<i class="fas fa-list"></i>')->action('function() { list() }');
        }

        if(PermissionCommon::check('wiki_header.export')) {
            // $button[] = Button::make('pdf')->text('<i class="fa fa-file-pdf"></i>');
            $button[] = Button::make('excel')->text('<i class="fa fa-file-excel"></i> Excel');
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
            // Column::make('id'),
            Column::make('versi'),
            Column::make('keterangan'),
            // Column::make('updated_at'),
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
