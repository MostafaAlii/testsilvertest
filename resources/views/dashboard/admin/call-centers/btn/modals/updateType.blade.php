<div class="modal fade" id="updateType{{ $callCenter->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('general.edit') .' '. $callCenter->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('callCenters.update-type', $callCenter->id)}}" method="POST">
                    @csrf
                    <!-- Start Type Status -->
                    <div class="p-1 form-group">
                        <label for="type">Type</label>
                        <select name="type" class="p-1 form-control">
                            <option selected disabled>Select <span class="text-primary">{{$callCenter->name}}</span>
                                Type...</option>
                            <option value="manager" {{ (old('type', $callCenter->type) == 'manager') ? 'selected' : '' }}>
                                Manager
                            </option>
                            <option value="callcenter" {{ (old('type', $callCenter->type) == 'callcenter') ? 'selected' : '' }}>
                                Call-Center
                            </option>
                        </select>
                        @error('type')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Type Selected -->

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