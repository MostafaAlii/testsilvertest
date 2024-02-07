<div class="modal fade" id="create_ticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('general.create') .' '. $data['title'] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('CallCenterTickets.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Start Title -->
                        <div class="form-group col-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" required name="title" id="title" value="">
                            @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- End Title -->

                        <!-- Start order code -->
                        <div class="form-group col-6">
                            <label for="order_code">Order Code</label>
                            <input type="order_code" class="form-control" required name="order_code" id="order_code" value="">
                            @error('order_code')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- End order code -->
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Subject</label>
                            <textarea class="form-control" id="subject" name="subject" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        {{--<div class="p-1 form-group col-md-6">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option selected disabled>Select {{$data['title']}} Status...</option>
                                <option value="close" {{ old('status')=='close' ? 'selected' : '' }}>
                                    Close
                                </option>
                                <option value="open" {{ old('status')=='open' ?'selected' : '' }}>
                                    Open
                                </option>
                            </select>
                            @error('status')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>--}}

                        <div class="p-1 form-group col-md-6">
                            <label for="priority">Priority</label>
                            <select name="priority" class="form-control">
                                <option selected disabled>Select {{$data['title']}} Priority...</option>
                                <option value="low" {{ old('priority')=='low' ? 'selected' : '' }}>
                                    Low
                                </option>
                                <option value="medium" {{ old('priority')=='medium' ?'selected' : '' }}>
                                    Medium
                                </option>
                                <option value="high" {{ old('priority')=='high' ?'selected' : '' }}>
                                    High
                                </option>
                            </select>
                            @error('priority')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('general.close')
                            }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('general.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>