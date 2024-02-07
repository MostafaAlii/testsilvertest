<div class="modal fade" id="updateHour{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('general.edit') .' '. $order->order_code }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('upcamingOrderHour.update-hour', $order->id)}}" method="POST">
                    @csrf
                    <!-- Start Type Status -->
                    <div class="row">
                        <div class="col-12">
                            <label for="hour_id">Hour</label>
                            <select name="hour_id" class="p-1 form-control">
                                <option selected disabled>Select <span class="text-primary">{{$order->order_code}}</span> Hour...</option>
                                @foreach(Hour::latest()->get(['id', 'number_hours']) as $hour)
                                <option value="{{$hour->id}}" {{ (old('hour_id', $order->hour_id) == $hour->id) ? 'selected' : '' }}>
                                    {{$hour->number_hours}}
                                </option>
                                @endforeach
                            </select>
                            @error('hour_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <br>
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