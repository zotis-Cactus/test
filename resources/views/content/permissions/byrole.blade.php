@extends('layouts/contentLayoutMaster')

@section('title', __('locale.Permissions'))

@section('vendor-style')
    @include('panels.datatable_styles')
@endsection

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
@endsection


@section('content')
    <form method="POST" action="{{ route('permissions.store') }}">
        @csrf
        <div class="card">
        <div class="card-header align-items-center">
            <h5 class="card-permssions-title mb-0">{{__('locale.Permissions')}}</h5>
            <div class="card-permssions-element">
                <button class="btn btn-primary btn-sm waves-effect waves-light" type="submit"><i class="fas fa-save fa-xs me-1"></i>{{__('Save')}}</button>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>Ρόλος</th>
                    <th>Δικαιώματα</th>
                    <th>Ενέργειες</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach(\Spatie\Permission\Models\Role::where('name','!=','super-admin')->get() as $role)
                    <tr>
                        <td>{{$role->name}}</td>
                        <td>
                            <label for="permissions_{{$role->id}}"></label>
                            <select name="permissions[{{$role->id}}][]" id="permissions_{{$role->id}}" class="form-select select2" multiple>
                                @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                                    <option @if($role->hasPermissionTo($permission->name)) selected @endif value="{{$permission->id}}">{{$permission->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <div class="form-check">
                                <input id="chk_{{$role->id}}" data-value="{{$role->id}}" type="checkbox" class="form-check-input chk_select"><label class="form-check-label" for="chk_{{$role->id}}">{{__('Select All')}}</label>
                            </div>
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>
    </form>


@endsection

@section('page-script')
    <script>
        $('.select2').select2();

        $(".chk_select").click(function(){
            var id = $(this).attr("data-value");
            if($(this).is(':checked')){
                $("#permissions_"+id+" > option").prop("selected", "selected");
                $("#permissions_"+id).trigger("change");
            } else {
                $("#permissions_"+id+" > option").removeAttr("selected");
                $("#permissions_"+id).trigger("change");
            }
        });
    </script>

@endsection
