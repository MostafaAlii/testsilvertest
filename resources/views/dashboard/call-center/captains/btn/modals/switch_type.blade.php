<div class="modal fade" id="switchType{{ $captain->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{  "Switch {$captain->name} Type" }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('captains.switchType', $captain->id ) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="checkbox" id="carToScooter" name="scooter">
                                <label for="carToScooter">Car to Scooter</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="checkbox" id="scooterToCar" name="car">
                                <label for="scooterToCar">Scooter to Car</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('general.close')
                            }}</button>
                        <button type="submit" class="btn btn-success">Switch</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>