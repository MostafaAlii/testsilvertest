<div class="modal fade" id="edit{{ $scooterModel->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('general.edit') .' '. $scooterModel->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('scooterModel.update', $scooterModel->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Start Name -->
                    <div class="form-group">
                        <label for="name">{{ trans('agents.name') }}</label>
                        <input type="text" class="form-control" required name="name" id="name"
                            value="{{$scooterModel->name}}">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Name -->
                    <!-- Start Status Status -->
                    <div class="p-1 form-group">
                        <label for="status">Status</label>
                        <select name="status" class="p-1 form-control">
                            <option selected disabled>Select <span class="text-primary">{{$scooterModel->name}}</span>
                                Status...</option>
                            <option value="1" {{ (old('status', $scooterModel->status) == '1') ? 'selected' : '' }}>
                                {{ trans('general.active') }}
                            </option>
                            <option value="0" {{ (old('status', $scooterModel->status) == '0') ? 'selected' : ''
                                }}>
                                {{ trans('general.inactive') }}
                            </option>
                        </select>
                        @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Status Selected -->
                    <!-- End Phone -->
                    <div class="p-1 form-group">
                        <!-- Start Country Selected -->
                        <label for="status">Scooter Make</label>
                        <select name="scooter_make_id" class="p-1 form-control">
                            <option selected disabled>Select <span class="text-primary">{{$scooterModel->name}}</span> Scooter
                                Make...</option>
                            @foreach(ScooterMake::active() as $scooter_make)
                            <option value="{{$scooter_make->id}}" {{ (old('scooter_make_id', $scooterModel->scooter_make_id) ==
                                $scooter_make->id) ? 'selected' : '' }}>
                                {{$scooter_make->name}}
                            </option>
                            @endforeach
                        </select>
                        <!-- End Country Selected -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('general.close')
                            }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('general.edit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>