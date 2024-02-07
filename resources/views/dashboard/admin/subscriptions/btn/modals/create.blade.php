<div class="modal fade" id="create_subscribtion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">create subscribtion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('subscriptions.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <!-- Start Name -->
                            <div class="form-group">
                                <label for="name">subscription Name Ar</label>
                                <input type="text" class="form-control" name="name_ar" id="name_ar" value="">
                                @error('name_ar')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">subscription Name En</label>
                                <input type="text" class="form-control" name="name_en" id="name_en" value="">
                                @error('name_en')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- End Name -->
                    <div class="row">
                        <!-- Start Notes -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="notes_ar">Notes Ar</label>
                                <textarea class="form-control" name="notes_ar" id="notes_ar" rows="3"></textarea>
                                @error('notes_ar')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="notes_en">Notes En</label>
                                <textarea class="form-control" name="notes_en" id="notes_en" rows="3"></textarea>
                                @error('notes_en')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- End Notes -->
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" name="price" id="price" value="">
                                @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- End Code -->
                        <!-- Start Type -->
                        <div class="col-6">
                            <div class="p-1 form-group">
                                <label for="type">Type</label>
                                <select name="type" class="form-control p-1">
                                    <option selected disabled>Select Type...</option>
                                    <option value="day" {{ old('type')== "day" ? 'selected' : '' }}>Day</option>
                                    <option value="week" {{ old('type')== "week" ?'selected' : '' }}>Week</option>
                                    <option value="month" {{ old('type')== "month" ?'selected' : '' }}>Month</option>
                                </select>
                                @error('type')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- End Type -->
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