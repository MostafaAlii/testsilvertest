<div class="modal fade" id="create{{ $title }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('general.create') .' '. $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('offer.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Title</label>
                        <input type="text" class="form-control" required name="title" id="title" value="">
                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Name -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Note 1</label>
                            <input type="text" class="form-control" required name="note_1" id="note_1" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Note 2</label>
                            <input type="text" class="form-control" required name="note_2" id="note_2" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Note 3</label>
                            <input type="text" class="form-control" name="note_3" id="note_3" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Note 4</label>
                            <input type="text" class="form-control" name="note_4" id="note_4" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Note 5</label>
                            <input type="text" class="form-control" name="note_5" id="note_5" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Note 6</label>
                            <input type="text" class="form-control" name="note_6" id="note_6" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Note 7</label>
                            <input type="text" class="form-control" name="note_7" id="note_7" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Note 8</label>
                            <input type="text" class="form-control" name="note_8" id="note_8" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Note 9</label>
                            <input type="text" class="form-control" name="note_9" id="note_9" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Note 10</label>
                            <input type="text" class="form-control" name="note_10" id="note_10" value="">
                        </div>
                    </div>
                    <!-- Start Status Status -->
                    <div class="form-group p-1">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option selected disabled>Select {{$title}} Status...</option>
                            <option value="1" {{ old('status')==1 ? 'selected' : '' }}>
                                {{ trans('general.active') }}
                            </option>
                            <option value="0" {{ old('status')==0 ?'selected' : '' }}>
                                {{ trans('general.inactive') }}
                            </option>
                        </select>
                        @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Status Selected -->
                    <div class="col-md-6">
                        <label>price</label>
                        <input type="text" class="form-control" name="price" id="price" value="">
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