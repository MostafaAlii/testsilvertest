<div class="modal fade" id="newCar{{$captain->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('general.create') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newCar" action="{{route('createNewCar')}}" method="POST">
                    @csrf
                    @method('POST')
                    @php
                        $data = [
                            'carMakes' => CarMake::with(['carModel' => function ($query) {
                                $query->where('status', true);
                            }])->whereStatus(true)->select('id', 'name')->get()->toArray(),
                            'carTypes' => CarType::active(),
                            'carCategories' => CategoryCar::active(),
                        ];
                    @endphp
                    <div class="row">
                        <!-- Start Captain Selected -->
                        <input type="hidden" name="captain_id" value="{{$captain->id }}" />
                        <!-- End Captain Selected -->
                        <div class="form-group col-4">
                            <label for="projectinput1">Car-Make</label>
                            <select name="car_make_id" id="car_makeId" class="form-control p-1 car_makeId">
                                <optgroup label="Select Car-Make">
                                    @foreach($data['carMakes'] as $carMake)
                                        <option value="{{ $carMake['id'] }}">{{ $carMake['name'] }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('car_make_id')
                            <span class="text-danger"> {{$message}}</span>
                            @enderror
                        </div>
                        <!-- End CarMake Selected -->
                        <div class="form-group col-4">
                            <label for="projectinput2">Car-Model</label>
                            <select name="car_model_id" id="car_modelId" class="form-control p-1"></select>
                            @error('car_model_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    <!-- End CarModel Selected -->
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="projectinput1">Car-Type</label>
                            <select name="car_type_id" class="form-control p-1">
                                <optgroup label="Select Car-Type">
                                    @if($data['carTypes'] && $data['carTypes']->count() > 0)
                                        @foreach($data['carTypes'] as $carType)
                                            <option value="{{$carType->id }}">{{$carType->name}}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                            @error('car_type_id')
                            <span class="text-danger"> {{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group col-6">
                            <label for="projectinput1">Car-Category</label>
                            <select name="category_car_id" class="form-control p-1">
                                <optgroup label="Select Car-Type">
                                    @if($data['carCategories'] && $data['carCategories']->count() > 0)
                                        @foreach($data['carCategories'] as $carCategory)
                                            <option value="{{$carCategory->id }}">{{$carCategory->name}}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                            @error('category_car_id')
                            <span class="text-danger"> {{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-4">
                            <label for="number_car">car number</label>
                            <input type="text" class="form-control" required name="number_car" id="number_car" value="">
                            @error('number_car')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-4">
                            <label for="year_car">car year</label>
                            <input type="text" class="form-control" required name="year_car" id="year_car" value="">
                            @error('year_car')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="car_color">Car Color</label>
                            <input type="color" name="car_color" class="form-control p-1" value="">
                            @error('car_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div id="colorPreview" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%; display:block;">
                            </div>
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


<script>
    $(document).ready(function () {
        var form = $('#newCar');
        form.on('change', '.car_makeId', function () {
            var carMakeId = $(this).val();
            $.ajax({
                url: '/callCenter/get-car-models/' + carMakeId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#car_modelId').empty();
                    $.each(data, function (name, id) {
                        $('#car_modelId').append('<option value="' + id + '">' + name + '</option>');
                    });
                    if (Object.keys(data).length > 0) {
                        $('#car_modelId').parent().show();
                    } else {
                        $('#car_modelId').parent().hide();
                    }
                },
                error: function (xhr, status, error) {
                }
            });
        });
        form.on('change', '#car_modelId', function () {
            var carModelId = $(this).val();
        });
    });
</script>