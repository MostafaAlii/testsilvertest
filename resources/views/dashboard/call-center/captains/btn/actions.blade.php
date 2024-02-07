<div class="mb-1 btn-group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">{{ trans('general.processes') }}</button>
    <div class="dropdown-menu">
        @if(get_user_data()->id == $captain->callcenter_id)
            <a href="{{ route('CallCenterCaptains.show', $captain->profile->uuid) }}"
               class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
            <span class="icon text-info text-dark">
                <i class="fa fa-edit"></i>
                Profile
            </span>
            </a>
        @endif

        <a href="{{ route('CallCenterCaptains.trips',  $captain->profile->uuid) }}"
            class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
            <span class="icon text-info text-dark">
                <i class="fa fa-edit"></i>
                My Trips
            </span>
        </a>
        @if ($captain->status_caption_type == 'scooter')
            @if(DB::table('captain_scooters')->where('captain_id', $captain->id)->exists())
                <a href="{{--route('CallCenterCaptains.myScooter',  $captain->id)--}}"
                    class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
                    <span class="icon text-info text-dark">
                        <i class="fa fa-edit"></i>
                        My Scooter
                    </span>
                </a>
            @else
                <a href="{{ route('CallCenterCaptains.captainNewScooter',  $captain->id) }}"
                    class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
                    <span class="icon text-info text-dark">
                        <i class="fa fa-edit"></i>
                        New Scooter
                    </span>
                </a>
            @endif
        @endif
        @if ($captain->status_caption_type == 'car')
            @if(DB::table('cars_captions')->where('captain_id', $captain->id)->exists())
                <a href="{{ route('CallCenterCaptains.myCar',  $captain->id) }}"
                    class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
                    <span class="icon text-info text-dark">
                        <i class="fa fa-edit"></i>
                        My Car
                    </span>
                </a>
            @else
                <a href="{{ route('CallCenterCaptains.captainNewCar',  $captain->id) }}"
                    class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
                    <span class="icon text-info text-dark">
                        <i class="fa fa-edit"></i>
                        New Car
                    </span>
                </a>
            @endif
        @endif

        @if ($captain->status_caption_type == 'tricycle')
            @if(DB::table('captain_tricycles')->where('captain_id', $captain->id)->exists())
                <a href="{{-- route('CallCenterCaptains.myCar',  $captain->id) --}}"
                    class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
                    <span class="icon text-info text-dark">
                        <i class="fa fa-edit"></i>
                        My Tricycle
                    </span>
                </a>
            @else
                <a href="{{-- route('CallCenterCaptains.captainNewCar',  $captain->id) --}}"
                    class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
                    <span class="icon text-info text-dark">
                        <i class="fa fa-edit"></i>
                        New Tricycle
                    </span>
                </a>
            @endif
        @endif
        {{--@if(DB::table('cars_captions')->where('captain_id', $captain->id)->exists())
            <a href="{{ route('CallCenterCaptains.myCar',  $captain->id) }}"
                class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
                <span class="icon text-info text-dark">
                    <i class="fa fa-edit"></i>
                    My Car
                </span>
            </a>
        @else
            <a href="{{ route('CallCenterCaptains.captainNewCar',  $captain->id) }}"
                class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
                <span class="icon text-info text-dark">
                    <i class="fa fa-edit"></i>
                    New Car
                </span>
            </a>
        @endif--}}

            @if(auth('call-center')->user()->type == "manager")
            <button type="button" class="modal-effect btn btn-sm btn-danger dropdown-item" style="text-align: center !important" data-toggle="modal" data-target="#delete{{$captain->id}}" data-effect="effect-scale">
            <span class="icon text-danger text-bold">
                <i class="fa fa-trash"></i>
                {{ trans('general.delete') }}
            </span>
            </button>

                <button type="button" class="modal-effect btn btn-sm btn-primary dropdown-item" style="text-align: center !important"
                        data-toggle="modal" data-target="#updatePassword{{$captain->id}}" data-effect="effect-scale">
            <span class="icon text-dark text-bold">
                <i class="fa fa-edit"></i>
                Update Password
            </span>
                </button>


                <button type="button" class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important" data-toggle="modal" data-target="#SendNotification{{$captain->id}}" data-effect="effect-scale">
            <span class="icon text-info text-bold">
                <i class="fa fa-bell"></i>
                Send Notifictation
            </span>
                </button>
            @endif
        @if(auth('call-center')->user()->type == "manager")
        <button type="button" class="modal-effect btn btn-sm btn-success dropdown-item"
                    style="text-align: center !important" data-toggle="modal" data-target="#switchType{{$captain->id}}"
                    data-effect="effect-scale">
            <span class="icon text-dark text-bold">
                <i class="fa fa-exchange"></i>
                Switch Type
            </span>
        </button>
        @endif
    </div>
</div>
@include('dashboard.call-center.captains.btn.modals.newCar')
@include('dashboard.call-center.captains.btn.modals.switch_type')
@include('dashboard.admin.captains.btn.modals.destroy')
@include('dashboard.admin.captains.btn.modals.notifications')
@include('dashboard.admin.captains.btn.modals.updatePassword')
