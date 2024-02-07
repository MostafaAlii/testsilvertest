<div class="modal fade" id="updateDate{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('general.edit') .' '. $order->order_code }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('upcamingOrderDay.update-date', $order->id)}}" method="POST">
                    @csrf
                    <!-- Start Type Status -->
                    <div class="row">
                        <div class="col-6">
                            <label>Start Day :</label>
                            <input type="date" name="start_day" class="form-control" value="{{ $order->start_day }}">
                            @error('start_day')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label>End Date :</label>
                            <input type="date" name="end_day" class="form-control" value="{{ $order->end_day }}">
                            @error('end_day')
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