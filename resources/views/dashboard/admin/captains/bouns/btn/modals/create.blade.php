<div class="modal fade" id="create_bouns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form action="{{route('captain-bouns.store')}}" method="POST">
                    @csrf
                    <div class="repeater">
                        <div data-repeater-list="listBounes">
                            <div data-repeater-item>
                                <div class="row">
                                    <div class="col">
                                        <label for="Name" class="mr-sm-2">Bouns :</label>
                                        <input type="text" class="form-control" required name="bout" id="bout" value="">
                                        @error('bout')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col p-1">
                                        <label for="captain_id" class="mr-sm-2">Select {{$data['title']}} Captain :</label>
                                        <div class="box">
                                            <select class="fancyselect" name="captain_id">
                                                @forelse ($data['captains'] as $captain)
                                                <option value="{{$captain->id}}" {{ old('captain_id')==$captain->id ? 'selected' : '' }}>
                                                    {{$captain->name }}
                                                </option>
                                                @empty
                                                    <option value="0">No Captain</option>
                                                @endforelse
                                            </select>
                                            @error('captain_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col p-1">
                                        <label for="status" class="mr-sm-2">Select {{$data['title']}} Status :</label>
                                        <div class="box">
                                            <select class="fancyselect" name="status">
                                                <option selected disabled>Select {{$data['title']}} Status...</option>
                                                <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>
                                                    {{trans('general.active') }}
                                                </option>
                                                <option value="inactive" {{ old('status')=='inactive' ?'selected' : '' }}>
                                                    {{trans('general.inactive') }}
                                                </option>
                                                <option value="waiting" {{ old('status')=='waiting' ?'selected' : '' }}>
                                                    {{trans('general.waiting') }}
                                                </option>
                                            </select>
                                            @error('status')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-12">
                                <input class="button" data-repeater-create type="button" value="Create New"/>
                            </div>
                        </div>
                        <br>
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