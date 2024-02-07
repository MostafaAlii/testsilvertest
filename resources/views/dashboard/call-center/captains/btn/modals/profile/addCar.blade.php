<div class="modal fade" id="addCar" tabindex="-1" role="dialog" aria-labelledby="carRejectModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ ucfirst(str_replace('_', ' ', $data['captain']?->name)) }} Car</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('CallCenterCaptains.updateProfile', $data['captain']?->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body mx-auto">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ $data['captain']?->profile?->address }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3">{{ $data['captain']?->profile?->bio }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Personal Number</label>
                            <input class="form-control" id="number_personal" name="number_personal" value="{{ $data['captain']?->profile?->number_personal }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>