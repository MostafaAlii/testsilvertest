<div class="tab-pane fade active show" id="scooter" role="tabpanel" aria-labelledby="scooter-tab">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="shadow accordion plus-icon">
                    @forelse($data['captain']->scooters as $scooter)
                    <div class="acd-group">
                        <a href="#" class="acd-heading">{{ $data['captain']?->name . ' ' . $scooter->scooter_number }}
                            Scooter Information</a>
                        <div class="acd-des">
                            <div>
                                <p class="mb-0">Scooter-Make: {{ $scooter->scooter_make->name }}</p>
                                <p class="mb-0">Scooter-Model: {{ $scooter->scooter_model->name }}</p>
                                <p class="mb-0">Scooter-Number: {{ $scooter->scooter_number }}</p>
                                <p class="mb-0">Scooter-Color: {{ $scooter->scooter_color }}</p>
                                <p class="mb-0">Scooter-Year: {{ $scooter->scooter_year }}</p>
                            </div>
                            <!-- Start Alert Div -->
                            <div class="col-12 d-flex justify-content-center mt-3">
                                <div class="col-xl-12 md-mt-30 mb-30">
                                    <div class="card card-statistics mb-30">
                                        <div class="card-body">
                                            <!-- Start Tabs -->
                                                <div class="tab nav-bt">
                                                    <!-- Start Nav Tabs -->
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active show" id="scooter-personal-03-tab"
                                                                data-toggle="tab" href="#scooter-personal-03" role="tab"
                                                                aria-controls="scooter-personal-03"
                                                                aria-selected="true">Scooter Personal Media</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link show" id="scooter-03-tab" data-toggle="tab"
                                                                href="#scooter-03" role="tab" aria-controls="scooter-03"
                                                                aria-selected="true">Scooter Media</a>
                                                        </li>
                                                    </ul>
                                                    <!-- End Nav Tabs -->
                                                    <!-- Start Tab Content -->
                                                    <div class="tab-content">
                                                        <!-- Start Scooter Personal Media 
                                                            Personal Column , ,  -->
                                                        <div class="tab-pane fade active show" id="scooter-personal-03" role="tabpanel" aria-labelledby="scooter-personal-03-tab">
                                                            <form method="POST" action="{{ route('CallCenterCaptains.uploadScooterPersonalMedia') }}" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="imageable_id" value="{{ $scooter->id }}">
                                                                <input type="hidden" name="type" value="personal">
                                                                <div class="row p-1">
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="personal_avatar" id="personal_avatar" />
                                                                            <label class="custom-file-label" for="personal_avatar">Choose Presonal Avatar Image (الصوره الشخصية)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="criminal_record" id="criminal_record" />
                                                                            <label class="custom-file-label" for="criminal_record">Choose Criminal Record Image ( الصحيفة الجنائية )</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row p-1">
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="id_photo_front" id="id_photo_front" />
                                                                            <label class="custom-file-label" for="id_photo_front">Choose id photo Front Image (الهوية امام)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="id_photo_back" id="id_photo_back" />
                                                                            <label class="custom-file-label" for="id_photo_back">Choose id photo back Image (الهوية خلف)</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row p-1">
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="captain_license_front" id="captain_license_front" />
                                                                            <label class="custom-file-label" for="captain_license_front">Choose Captain License Front Image ( رخصة السائق امام  )</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="captain_license_back" id="captain_license_back" />
                                                                            <label class="custom-file-label" for="captain_license_back">Choose Captain License Back Image ( رخصة السائق خلف  )</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row p-1">
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="scooter_license_front" id="scooter_license_front" />
                                                                            <label class="custom-file-label" for="scooter_license_front">Choose Scooter License Front Image ( رخصة الدراجة امام  )</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="scooter_license_back" id="scooter_license_back" />
                                                                            <label class="custom-file-label" for="scooter_license_back">Choose Scooter License Back Image ( رخصة الدراجة خلف  )</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-success d-block" style="margin:auto; position: relative; top: 10px; width: 30% !important;">
                                                                    Upload Scooter Personal Media
                                                                </button>
                                                            </form>
                                                            <br>
                                                        </div>
                                                        <!-- Scooter Column scooter_front, scooter_back -->
                                                        <!-- End Scooter Personal Media -->
                                                        <!-- Start Scooter Media -->
                                                        <div class="tab-pane fade show" id="scooter-03" role="tabpanel" aria-labelledby="scooter-03-tab">
                                                            <form method="POST" action="{{ route('CallCenterCaptains.uploadScooterMedia') }}" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="imageable_id" value="{{ $scooter->id }}">
                                                                <input type="hidden" name="type" value="scooter">
                                                                <div class="row p-1">
                                                                     <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="scooter_front" id="scooter_front" />
                                                                            <label class="custom-file-label" for="scooter_front">Choose Scooter Front Image ( الدراجة  امام  )</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" name="scooter_back" id="scooter_back" />
                                                                            <label class="custom-file-label" for="scooter_back">Choose Scooter Back Image ( الدراجة خلف  )</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-success d-block" style="margin:auto; position: relative; top: 10px; width: 30% !important;">
                                                                    Upload Scooter Media
                                                                </button>
                                                            </form>
                                                            <br>
                                                        </div>
                                                        <!-- End Scooter Media -->
                                                    </div>
                                                    <!-- End Tab Content -->
                                                </div>
                                            <!-- End Tabs -->
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Image Name</th>
                                                        <th>Type</th>
                                                        <th>Status</th>
                                                        <th>ِActions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['captain']['scooters'] as $scooter)
                                                        @foreach ($scooter->scooterImages as $image)
                                                            @php
                                                            $imagePath = asset('dashboard/img/' . str_replace(' ',
                                                            '_', $data['captain']->name) . '_' .
                                                            $data['captain']->profile->uuid . '/scooter//' . $scooter->scooter_number . '/' .
                                                            $image->type .
                                                            '/' . $image->filename);
                                                            @endphp
                                                        <tr>
                                                            <td><img src="{{ $imagePath }}" alt="{{ $image->photo_type }}" width="50"></td>
                                                            <td>{{ ucfirst(str_replace('_', ' ', $image->photo_type)) }}</td>
                                                            <td>{{ $image->type }}</td>
                                                            <td>{{ ucfirst(str_replace('_', ' ', $image->photo_status)) }}</td>
                                                            <td>
                                                                @if($image->photo_status !== 'accept')
                                                                <div class="mb-1 btn-group">
                                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">{{
                                                                        trans('general.processes') }}</button>
                                                                    <div class="dropdown-menu">
                                                                        <a type="button" class="modal-effect btn btn-sm btn-success dropdown-item"
                                                                            style="text-align: center !important" data-toggle="modal" data-target="#active{{ $image->id }}"
                                                                            data-effect="effect-scale">
                                                                            <span class="icon text-success text-bold">
                                                                                <i class="fa fa-edit"></i>
                                                                                Active
                                                                            </span>
                                                                        </a>
                                                                        <a type="button" class="modal-effect btn btn-sm btn-warning dropdown-item"
                                                                            style="text-align: center !important" data-toggle="modal" data-target="#reject{{ $image->id }}"
                                                                            data-effect="effect-scale">
                                                                            <span class="icon text-warning text-bold">
                                                                                <i class="fa fa-edit"></i>
                                                                                Reject
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @if ($image->photo_status === 'rejected')
                                                        <tr>
                                                            <td colspan="5">
                                                                <div>
                                                                    <strong class="text-danger">Reject
                                                                        Reason:</strong>
                                                                    {{ $image->reject_reson }}
                                                                </div>
                                                                <form action="{{ route('CallCenterCaptains.uploadScoterRejectedImage') }}" method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="image_id" value="{{ $image->id }}">
                                                                    <input type="hidden" name="imageable_id" value="{{ $image->imageable_id }}">
                                                    
                                                                    <label for="replacement_image">Upload Replacement Image:</label>
                                                                    <input type="file" name="filename" id="replacement_image">
                                                                    <button class="btn btn-success" type="submit">Upload</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @include('dashboard.call-center.captains.btn.modals.scooter.active')
                                                        @include('dashboard.call-center.captains.btn.modals.scooter.reject')
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Alert Div -->
                            @empty
                            <p>No scooters available for this captain.</p>
                            
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>