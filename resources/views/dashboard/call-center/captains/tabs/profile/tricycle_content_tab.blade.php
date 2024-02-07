<div class="tab-pane fade active show" id="tricycle" role="tabpanel" aria-labelledby="tricycle-tab">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="shadow accordion plus-icon">
                    @forelse($data['captain']->tricycles as $tricycle)
                    <div class="acd-group">
                        <a href="#" class="acd-heading">{{ $data['captain']?->name . ' ' . $tricycle->tricycle_number }}
                            Tricycle Information</a>
                        <div class="acd-des">
                            <div>
                                <p class="mb-0">Tricycle-Make: {{ $tricycle->tricycle_make->name }}</p>
                                <p class="mb-0">Tricycle-Model: {{ $tricycle->tricycle_model->name }}</p>
                                <p class="mb-0">Tricycle-Number: {{ $tricycle->tricycle_number }}</p>
                                <p class="mb-0">Tricycle-Color: {{ $tricycle->tricycle_color }}</p>
                                <p class="mb-0">Tricycle-Year: {{ $tricycle->tricycle_year }}</p>
                            </div>
                            <!-- Start Alert Div -->
                            <div class="col-12 d-flex justify-content-center mt-3">
                                <div class="col-xl-12 md-mt-30 mb-30">
                                    <div class="card card-statistics mb-30">
                                        <div class="card-body">
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
                                                    @foreach ($data['captain']['tricycles'] as $tricycle)
                                                        @foreach ($tricycle->tricycleImages as $image)
                                                            @php
                                                            $imagePath = asset('dashboard/img/' . str_replace(' ',
                                                            '_', $data['captain']->name) . '_' .
                                                            $data['captain']->profile->uuid . '/tricycle//' . $tricycle->tricycle_number . '/' .
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
                                                                <form action="{{ route('CallCenterCaptains.uploadTricycleRejectedImage') }}" method="post" enctype="multipart/form-data">
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
                                                        @include('dashboard.call-center.captains.btn.modals.tricycle.active')
                                                        @include('dashboard.call-center.captains.btn.modals.tricycle.reject')
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