<div class="mb-1 btn-group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ trans('general.processes') }}</button>
    <div class="dropdown-menu">
        <a href="{{ route('upcamingOrderDay.show', $order->order_code) }}" class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
            <span class="icon text-info text-dark">
                <i class="fa fa-eye"></i>
                Show Details
            </span>
        </a>
        <button type="button" class="modal-effect btn btn-sm btn-primary dropdown-item" style="text-align: center !important"
            data-toggle="modal" data-target="#updateDate{{$order->id}}" data-effect="effect-scale">
            <span class="icon text-dark text-bold">
                <i class="fa fa-edit"></i>
                Update Date
            </span>
        </button>
        <button type="button" class="modal-effect btn btn-sm btn-success dropdown-item" style="text-align: center !important"
            data-toggle="modal" data-target="#updateTime{{$order->id}}" data-effect="effect-scale">
            <span class="icon text-dark text-bold">
                <i class="fa fa-edit"></i>
                Update Time
            </span>
        </button>
    </div>
</div>

@include('dashboard.admin.orders.orderDay.upcaming.btn.modals.updateDate')
@include('dashboard.admin.orders.orderDay.upcaming.btn.modals.updateTime')