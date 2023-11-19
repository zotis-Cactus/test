@extends('layouts/contentLayoutMaster')

@section('title', __('locale.Users'))

@section('vendor-style')
    @include('panels.datatable_styles')
@endsection

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
@endsection


@section('content')


<!--/ Column Search -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>id</th>
                        <th>{{__('Log Name')}}</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('Subject Type')}}</th>
                        <th>{{__('Event')}}</th>

                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection

@section('vendor-script')
  @include('panels.datatable_scripts')
@endsection

@section('page-script')
    <script>
        var dt_basic_table = $('.datatables-basic');
        if (dt_basic_table.length) {
            var dt_basic = dt_basic_table.DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('datatable.logs')}}",
                columns: [
                    { data: 'id' },
                    { data: 'id' },
                    { data: 'id' }, // used for sorting so will hide this column
                    { data: 'log_name' },
                    { data: 'description'},
                    { data: 'subject_type' },
                    { data: 'event' }
                ],
                columnDefs: [
                    {
                        // For Responsive
                        className: 'control',
                        orderable: false,
                        responsivePriority: 2,
                        targets: 0
                    },
                    {
                        // For Checkboxes
                        targets: 1,
                        orderable: false,
                        responsivePriority: 3,
                        render: function (data, type, full, meta) {
                            return (
                                '<div class="form-check"> <input class="form-check-input dt-checkboxes" type="checkbox" value="" id="checkbox' +
                                data +
                                '" /><label class="form-check-label" for="checkbox' +
                                data +
                                '"></label></div>'
                            );
                        },
                        checkboxes: {
                            selectAllRender:
                                '<div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="form-check-label" for="checkboxSelectAll"></label></div>'
                        }
                    },
                    {
                        targets: 2,
                        visible: false
                    },
                    {
                        responsivePriority: 1,
                        targets: 4
                    },
                ],
                order: [[2, 'desc']],
                dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 10,
                lengthMenu: [10, 25, 50, 100],
                buttons: [
                    {
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + '{{ __('locale.Export')  }}',
                        buttons: [
                            {
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4] }
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4] }
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4] }
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4] }
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                                className: 'dropdown-item',
                                exportOptions: { columns: [3, 4] }
                            }
                        ],
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                            $(node).parent().removeClass('btn-group');
                            setTimeout(function () {
                                $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                            }, 50);
                        }
                    }
                ],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return 'Details of ' + data['full_name'];
                            }
                        }),
                        type: 'column',
                        renderer: function (api, rowIdx, columns) {
                            var data = $.map(columns, function (col, i) {
                                return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                    ? '<tr data-dt-row="' +
                                    col.rowIdx +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>'
                                    : '';
                            }).join('');

                            return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
                        }
                    }
                },
                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    },
                    "lengthMenu": "{{__('locale.Show')}} _MENU_ {{__('locale.Entries')}}",
                    "zeroRecords": "{{__('locale.Nothing Found')}}",
                    "info": "{{__('locale.Showing')}} _START_ {{__('until')}} _END_ {{__('locale.Entries')}}",
                    "infoEmpty": "{{__('locale.Nothing Found')}}",
                    "loadingRecords": "{{ __('locale.Loading')  }}",
                    sProcessing: '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>',
                    "search": "{{ __('locale.Search') }}",
                },
            });
            $('div.head-label').html('<h6 class="mb-0">{{__('Logs')}}</h6>');
        }
    </script>
@endsection




