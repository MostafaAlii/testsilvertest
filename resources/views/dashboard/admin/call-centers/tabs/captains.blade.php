<div class="table-responsive">
    <table id="datatable" class="table table-hover table-sm table-bordered p-0" data-page-length="10" style="text-align: center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['captains'] as $captain)
            <tr>
                <td>{{ $captain->id }}</td>
                <td>{{ $captain->name }}</td>
                <th>
                    {!! \App\Services\Dashboard\Admins\CallCenterService::getImageStatus([$captain]) !!}
                </th>
                <td>
                    <div class="mb-1 btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">{{ trans('general.processes') }}</button>
                        <div class="dropdown-menu">
                            <a href="{{ route('CallCenterCaptains.show', $captain->profile->uuid) }}"
                                class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
                                <span class="icon text-info text-dark">
                                    <i class="fa fa-edit"></i>
                                    Profile
                                </span>
                            </a>
                    
                            <a href="{{ route('CallCenterCaptains.trips',  $captain->profile->uuid) }}"
                                class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
                                <span class="icon text-info text-dark">
                                    <i class="fa fa-edit"></i>
                                    My Trips
                                </span>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>