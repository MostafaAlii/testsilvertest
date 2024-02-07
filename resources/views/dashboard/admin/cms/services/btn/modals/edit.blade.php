<div class="modal fade" id="edit{{$service->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('general.edit') .' '. $service?->title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('service.update', $service->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{$service->title}}">
                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Body</label>
                            <textarea class="form-control" id="body" name="body" rows="3">
                                {!! $service->body !!}
                            </textarea>
                        </div>
                    
                        <div class="col-md-6">
                            <label>Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">
                                {!! $service->description !!}
                            </textarea>
                        </div>
                    </div>

                    <div class="p-1 form-group">
                        <label for="status">Status</label>
                        <select name="status" class="p-1 form-control">
                            <option selected disabled>Select <span class="text-primary">{{$service->title}}</span>
                                Status...</option>
                            <option value="1" {{ (old('status', $service->status) == 1 ) ? 'selected' : ''}}>
                                {{ trans('general.active') }}
                            </option>
                            <option value="0" {{ (old('status', $service->status) == 0 ) ? 'selected' : '' }}>
                                {{ trans('general.inactive') }}
                            </option>
                        </select>
                        @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
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