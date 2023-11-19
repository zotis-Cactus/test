<div>
    <div wire:ignore.self class="modal fade" id="edit-user">
        <div class="modal-dialog sidebar-sm">
            <form class="modal-content pt-0" wire:submit.prevent="updateUser">
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('locale.New Record')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="mb-1">
                        <label class="form-label" for="basic-icon-default-fullname">{{__('locale.Name')}}</label>
                        <input wire:model="name" type="text" class="form-control"/>
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="basic-icon-default-email">Email</label>
                        <input wire:model="email" type="text" class="form-control"/>
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="role">{{__('Role')}}</label>
                        <div wire:ignore>
                            <select id="edit-role" wire:model="role" class="form-select select2" multiple>
                                <option value="">{{__('Select Role')}}</option>
                                @foreach(\Spatie\Permission\Models\Role::where('name','!=','super-admin')->get() as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('role') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary data-submit me-1">{{__('locale.Submit')}}</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__('locale.Cancel')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $( document ).ajaxStop(function() {
            //$('#edit-role').select2();
            $('#edit-role').on('change', function (e) {
                var data = $('#edit-role').select2("val");
                @this.set('role', data);
            });
            Livewire.on('UserRole', role => {
                $('#edit-role').val(role).trigger("change");
            })
        });
    </script>
@endpush
