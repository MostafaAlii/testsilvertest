<div class="tab-pane fade" id="scooters-04" role="tabpanel" aria-labelledby="scooters-04-tab">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="shadow accordion plus-icon">
                    @foreach($data['captain']->scooters as $index => $scooter)
                        <div class="acd-group">
                            <a href="#" class="acd-heading">
                                @unless($index)
                                    {{ ucfirst($scooter->scooter_type . ' Scooter ')  . $scooter->scooter_number }}
                                @else
                                    Scooter {{ $scooter->scooter_number }}
                                @endunless
                            </a>
                            <div class="acd-des">
                                <div class="row">
                                    <div class="col-md-3">
                                        <p>Scooter Make: {{ $scooter->scooter_make?->name }}</p>
                                        <p>Scooter Model: {{ $scooter->scooter_model?->name }}</p>
                                        <p>Scooter Number: {{ $scooter?->scooter_number }}</p>
                                    </div>
                                    <div class="col-md-9 border p-2">
                                        <div class="p-1 col-12 d-flex justify-content-center">
                                            @if ($data['captain']->scooters)
                                                @php
                                                    $emptyScooterField = collect(['scooter_front', 'scooter_back'])->filter(function ($field) use ($data) {
                                                        return empty($data['captain']->scooters->first()->scooterImages->where('photo_type', $field)->first());
                                                    });
                                                
                                                    $emptyScooterPersonalField = collect([
                                                        'personal_avatar',
                                                        'id_photo_front',
                                                        'id_photo_back',
                                                        'criminal_record',
                                                        'captain_license_front',
                                                        'captain_license_back'
                                                    ])->filter(function ($field) use ($data) {
                                                        return empty($data['captain']->scooters->first()->scooterImages->where('photo_type', $field)->first());
                                                    });
                                                @endphp

                                                <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                                                    <form method="post" action="{{ route('captains.uploadScooterMedia') }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @foreach ($data['captain']->scooters as $scooter)
                                                            @foreach ($emptyScooterField as $field)
                                                                @if (!$scooter->scooterImages->contains('photo_type', $field))
                                                                    <p class="alert alert-danger pull-left">
                                                                        صورة مفقودة: {{ ucfirst(str_replace('_', ' ', $field)) }} للـ Scooter رقم {{ $scooter->scooter_number }} مستندات سكوتر
                                                                    </p>
                                                                    <div class="mb-3">
                                                                        <label class="form-label d-block pull-right" for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                                                        <input type="file" class="form-control-file" id="{{ $field }}" name="{{ $field }}">
                                                                    </div>
                                                                @endif
                                                            @endforeach

                                                            @foreach ($emptyScooterPersonalField as $field)
                                                                @if (!$scooter->scooterImages->contains('photo_type', $field))
                                                                    <p class="alert alert-danger pull-left">
                                                                        صورة مفقودة: {{ ucfirst(str_replace('_', ' ', $field)) }} للـ Scooter رقم {{ $scooter->scooter_number }}
                                                                        مستندات شخصية
                                                                    </p>
                                                                    <div class="mb-3">
                                                                        <label class="form-label d-block pull-right" for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                                                        <input type="file" class="form-control-file" id="{{ $field }}" name="{{ $field }}">
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                            <div class="row p-1 col-12 d-flex justify-content-center">
                                                                <button type="submit" data-effect="effect-scale"
                                                                    class="btn btn-success btn-sm" role="button">
                                                                    <i class="fa fa-plus"></i>
                                                                    Upload
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>