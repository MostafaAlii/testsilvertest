<div class="tab-pane fade active show" id="profile-03" role="tabpanel" aria-labelledby="profile-03-tab">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="shadow accordion plus-icon">
                    <div class="acd-group">
                        <!-- Start Personal Media Upload -->
                        <a href="#" class="acd-heading">{{ $data['captain']?->name }} Information</a>
                        <div class="acd-des">
                            <div>
                                <p class="mb-0">Name: {{ $data['captain']?->name }}</p>
                                <p class="mb-0">Email: {{ $data['captain']?->email }}</p>
                                <p class="mb-0">Status: {{ $data['captain']?->status }}</p>
                                <p class="mb-0">Gender: {{ $data['captain']?->gender }}</p>
                                <p class="mb-0">Phone: {{ $data['captain']?->phone }}</p>
                                <p class="mb-0">Personal ID: <span class="text-success">{{
                                        $data['captain']?->profile?->number_personal }}</span>
                                </p>
                                {{--<p class="mb-0">Added By:
                                    @if ($data['captain']?->admin_id !== null)
                                    <span class="text-primary">(Admin)</span> {{ $data['captain']->admin->name }}
                                    @endif
                                    @if ($data['captain']?->agent_id !== null)
                                    <span class="text-green-500">(Agent)</span> {{ $data['captain']->agent->name }}
                                    @endif
                                    @if ($data['captain']?->employee_id !== null)
                                    <span class="text-purple-500">(Employee)</span>
                                    {{ $data['captain']->employee->name }}
                                    @endif
                                </p>--}}
                                <p class="mb-0">From: {{ $data['captain']?->country->name }}</p>
                                <!-- Start Alert Div -->
                                <div class="col-12 d-flex justify-content-center mt-3">
                                    <!-- Start Personal Media Upload -->
                                    <div class="col-xl-12 md-mt-30 mb-30">
                                        <div class="card card-statistics mb-30">
                                            <div class="card-body">
                                                <!-- New -->
                                                <div class="tab nav-bt">
                                                    <!-- Start Nav Tabs -->
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active show" id="personal-03-tab"
                                                                data-toggle="tab" href="#personal-03" role="tab"
                                                                aria-controls="personal-03"
                                                                aria-selected="true">Personal Media</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link show" id="car-03-tab" data-toggle="tab"
                                                                href="#car-03" role="tab" aria-controls="car-03"
                                                                aria-selected="true">Car Media</a>
                                                        </li>
                                                    </ul>
                                                    <!-- End Nav Tabs -->
                                                    <!-- Start Tab Content -->
                                                    <div class="tab-content">
                                                        <!-- Start Personal Media -->
                                                        <div class="tab-pane fade active show" id="personal-03"
                                                            role="tabpanel" aria-labelledby="personal-03-tab">
                                                            <form method="POST"
                                                                action="{{ route('CallCenterCaptains.uploadMedia') }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <!-- Personal Media
                                                                    personal_avatar, id_photo_front, id_photo_back,
                                                                    criminal_record, captain_license_front, captain_license_back
                                                                -->
                                                                <input type="hidden" name="imageable_id"
                                                                    value="{{ $data['captain'] }}">
                                                                <input type="hidden" name="type" value="personal">

                                                                <div class="row p-1">
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="personal_avatar"
                                                                                id="personal_avatar" />
                                                                            <label class="custom-file-label"
                                                                                for="personal_avatar">Choose Presonal Avatar Image (الصوره الشخصية)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="id_photo_front"
                                                                                id="id_photo_front" />
                                                                            <label class="custom-file-label"
                                                                                for="id_photo_front">Choose ID Front Side Image (الهوية امام)</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row p-1">
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="id_photo_back"
                                                                                id="id_photo_back" />
                                                                            <label class="custom-file-label"
                                                                                for="id_photo_back">Choose ID Back Side Image (الهوية خلف)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="criminal_record"
                                                                                id="criminal_record" />
                                                                            <label class="custom-file-label"
                                                                                for="criminal_record">Choose Criminal Record Image (الصحيفة الجنائية)</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row p-1">
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="captain_license_front"
                                                                                id="captain_license_front" />
                                                                            <label class="custom-file-label"
                                                                                for="captain_license_front">Choose Captain License Front (رخصة القياده امام)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="captain_license_back"
                                                                                id="captain_license_back" />
                                                                            <label class="custom-file-label"
                                                                                for="captain_license_back"> Choose Captain License Back Image (رخصة القياده خلف)
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <button type="submit" class="btn btn-success d-block"
                                                                    style="margin:auto; position: relative; top: 10px; width: 30% !important;">
                                                                    Upload Personal Media
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <!-- End Personal Media -->
                                                        <!-- Start Car Media -->
                                                        <div class="tab-pane fade show" id="car-03" role="tabpanel"
                                                            aria-labelledby="car-03-tab">
                                                            <form method="POST"
                                                                action="{{ route('CallCenterCaptains.uploadCarMedia') }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <!-- Car Media
                                                                    'car_license_front', 'car_license_back','car_front',
                                                                    'car_back', 'car_right', 'car_left', 'car_inside',
                                                                -->
                                                                <input type="hidden" name="imageable_id"
                                                                    value="{{ $data['captain'] }}">
                                                                <input type="hidden" name="type" value="car">
                                                                <div class="row p-1">
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="car_license_front"
                                                                                id="car_license_front" />
                                                                            <label class="custom-file-label"
                                                                                for="car_license_front">Choose Car
                                                                                License Front Image (رخصة السياره امام)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="car_license_back"
                                                                                id="car_license_back" />
                                                                            <label class="custom-file-label"
                                                                                for="car_license_back">Choose Car
                                                                                License Back Image (رخصة السياره خلف)</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row p-1">
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="car_front" id="car_front" />
                                                                            <label class="custom-file-label"
                                                                                for="car_front">Choose Car Front
                                                                                Image ( السياره امام)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="car_back" id="car_back" />
                                                                            <label class="custom-file-label"
                                                                                for="car_back">Choose Car Back
                                                                                Image ( السياره خلف)</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row p-1">
                                                                    <div class="col-4">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="car_right" id="car_right" />
                                                                            <label class="custom-file-label"
                                                                                for="car_right">Choose Car Right
                                                                                Image ( السياره يمين)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="car_left" id="car_left" />
                                                                            <label class="custom-file-label"
                                                                                for="car_left">Choose Car Left
                                                                                Image ( السياره يسار)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                name="car_inside" id="car_inside" />
                                                                            <label class="custom-file-label"
                                                                                for="car_inside">Choose Car Inside
                                                                                Image ( السياره من الداخل)</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <button type="submit" class="btn btn-success d-block"
                                                                    style="margin:auto; position: relative; top: 10px; width: 30% !important;">
                                                                    Upload Car Media
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <!-- End Car Media -->
                                                    </div>
                                                    <!-- End Tab Content -->
                                                </div>
                                                <!-- New -->
                                                <br>
                                                <!-- Start Personal Media Table -->
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

                                                        @forelse ($data['captain']['images'] as $image)
                                                        <tr>
                                                            <td>
                                                                @php
                                                                $imagePath = asset('dashboard/img/' . str_replace(' ',
                                                                '_', $data['captain']->name) . '_' .
                                                                $data['captain']->profile->uuid . '/' . $image->type .
                                                                '/' . $image->filename);
                                                                @endphp
                                                                <img src="{{ $imagePath }}"
                                                                    alt="{{ $image->photo_type }}" width="100">
                                                            <td>{{ ucfirst(str_replace('_', ' ', $image->photo_type)) }}
                                                            </td>
                                                            <td>{{ $image->type }}</td>
                                                            <td>{{ ucfirst(str_replace('_', ' ', $image->photo_status))
                                                                }}
                                                            </td>
                                                            <td>
                                                                @if($image->photo_status !== 'accept')
                                                                <div class="mb-1 btn-group">
                                                                    <button type="button"
                                                                        class="btn btn-default dropdown-toggle"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">{{
                                                                        trans('general.processes') }}</button>
                                                                    <div class="dropdown-menu">
                                                                        <a type="button"
                                                                            class="modal-effect btn btn-sm btn-success dropdown-item"
                                                                            style="text-align: center !important"
                                                                            data-toggle="modal"
                                                                            data-target="#active{{ $image->id }}"
                                                                            data-effect="effect-scale">
                                                                            <span class="icon text-success text-bold">
                                                                                <i class="fa fa-edit"></i>
                                                                                Active
                                                                            </span>
                                                                        </a>
                                                                        <a type="button"
                                                                            class="modal-effect btn btn-sm btn-warning dropdown-item"
                                                                            style="text-align: center !important"
                                                                            data-toggle="modal"
                                                                            data-target="#reject{{ $image->id }}"
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
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @include('dashboard.call-center.captains.btn.modals.profile.active')
                                                        @include('dashboard.call-center.captains.btn.modals.profile.reject')
                                                        @empty
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                <!-- Start Personal Media Table -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Personal Media Upload -->

                                </div>
                                <!-- End Alert Div -->
                            </div>
                        </div>
                        <!-- End Personal Media Upload -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
