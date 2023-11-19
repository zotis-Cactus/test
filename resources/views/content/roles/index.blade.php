@extends('layouts/contentLayoutMaster')

@section('title', __('Roles'))

@section('vendor-style')
    @include('panels.datatable_styles')
@endsection

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/form-validation.css')}}">
@endsection


@section('content')
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
                            <th>{{ __('Name') }}</th>
                            @can('crud roles') <th>{{ __('Actions') }}</th> @endcan
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <div>
        <div class="modal fade" id="modal-form">
            <div class="modal-dialog sidebar-sm">
                <form method="post" id="model-form" novalidate class="add-new-record needs-validation model-form modal-content pt-0">
                    @csrf
                    <div class="modal-header mb-1">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-fullname">{{__('Name')}}</label>
                            <input name="name" type="text" required class="form-control"/>
                            <div class="valid-feedback">Φαίνεται εντάξει!</div>
                            <div class="invalid-feedback">Παρακαλώ συμπληρώστε το όνομα.</div>
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary data-submit me-1">{{__('Submit')}}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('modals')

    {{--<div class="modal fade" id="modals-slide-in">
        <div class="modal-dialog sidebar-sm">
            <form method="post" id="sim-form" class="add-new-record modal-content pt-0" action="{{route('sims.store')}}">
                {{csrf_field()}}
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('locale.New Record')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="mb-1">
                        <label class="form-label" for="basic-icon-default-fullname">Τηλέφωνο</label>
                        <input type="tel" class="form-control dt-full-name" id="basic-icon-default-fullname"
                               placeholder="+306949281396"
                               aria-label="+306949281396"
                               name="number" autocomplete="off"/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="basic-icon-default-email">QR</label>
                        <input
                            type="text"
                            id="basic-icon-default-email"
                            class="form-control dt-email"
                            name="installation_code"
                        />
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="offer_id">Πακέτο</label>
                        <select name="offer_id[]" class="form-select select2" multiple="multiple">
                            <option value="">Επιλέξτε πακέτο</option>
                            @foreach(\App\Models\Offer::where('type_of_offer',1)->get() as $offer)
                                <option value="{{$offer->id}}">{{$offer->name}} | {{ $offer->cost }} € | {{ $offer->country()->first()->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="type" value="1">
                    <button type="submit" class="btn btn-primary data-submit me-1">{{__('locale.Submit')}}</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__('locale.Cancel')}}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="upload">
        <div class="modal-dialog sidebar-sm">
            <form method="post" enctype="multipart/form-data" class="add-new-record modal-content pt-0" action="{{route('sims.upload')}}">
                {{csrf_field()}}
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Ανεβάστε το excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="mb-1">
                        <a href="#" target="_blank"><i data-feather='download' class="mx-1"></i>Κατεβάστε το πρότυπο εδώ.</a>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="offer_id">Πακέτο</label>
                        <select name="offer_id[]" class="form-select select2" multiple="multiple">
                            <option value="">Επιλέξτε πακέτο</option>
                            @foreach(\App\Models\Offer::where('type_of_offer',1)->get() as $offer)
                                <option value="{{$offer->id}}">{{$offer->name}} | {{ $offer->cost }} € | {{ $offer->country()->first()->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="form-label" for="basic-icon-default-fullname">Excel</label>
                        <input type="file" class="form-control dt-full-name" name="excel" autocomplete="off"/>
                    </div>
                    <input type="hidden" name="type" value="1">
                    <button type="submit" class="btn btn-primary data-submit me-1">{{__('locale.Submit')}}</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__('locale.Cancel')}}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="edit-record">
        <div class="modal-dialog sidebar-sm">
            <form method="post" id="edit-record-action" class="form-sim add-new-record modal-content pt-0">
                {{csrf_field()}}
                <input name="_method" type="hidden" value="PATCH">
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Edit')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="mb-1">
                        <label class="form-label" for="basic-icon-default-fullname">Τηλέφωνο</label>
                        <input type="tel"
                               class="form-control dt-full-name"
                               id="edit-number"
                               placeholder="+306949281396"
                               aria-label="+306949281396"
                               name="number"/>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="basic-icon-default-email">QR</label>
                        <input
                            type="text"
                            id="edit-installation-code"
                            class="form-control dt-email"
                            name="installation_code"
                        />
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="offer_id">Πακέτο</label>
                        <select name="offer_id[]" id="edit-offer-id" class="form-select select2" multiple="multiple">
                            <option value="">Επιλέξτε πακέτο</option>
                            @foreach(\App\Models\Offer::where('type_of_offer',1)->get() as $offer)
                                <option value="{{$offer->id}}">{{$offer->name}} | {{ $offer->cost }} €</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary data-submit me-1">{{__('locale.Submit')}}</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__('locale.Cancel')}}</button>
                </div>
            </form>
        </div>
    </div>--}}


@endpush

@section('vendor-script')
    @include('panels.datatable_scripts')
    <script src="{{asset('js/scripts/forms/form-validation.js')}}"></script>
@endsection
@section('page-script')
    <script>
        var dt_basic_table = $('.datatables-basic');
        if (dt_basic_table.length) {
            var dt_basic = dt_basic_table.DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('datatable.roles')}}",
                columns: [
                    { data: 'id' },
                    { data: 'id' },
                    { data: 'id' }, // used for sorting so will hide this column
                    { data: 'name' },
                    @can('crud roles')
                    {
                        data: 'actions',
                        orderable : false,
                        searchable : true,
                        exportable : true,
                        printable: false,
                    },
                    @endcan
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
                    }
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
                    },
                    {
                        text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + '{{ __('New Record')  }}',
                        className: 'create-new btn btn-primary',
                        attr: {
                            'data-bs-toggle': 'modal',
                            'data-bs-target': '#modal-form',
                            'data-model-name': 'role',
                            'data-type': 'create',
                        },
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
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
            $('div.head-label').html('<h6 class="mb-0">{{__('Roles')}}</h6>');
        }
    </script>

    @include('content.js.delete')
    {{--@include('content.js.validation')--}}
    @include('content.js.edit')
@endsection
