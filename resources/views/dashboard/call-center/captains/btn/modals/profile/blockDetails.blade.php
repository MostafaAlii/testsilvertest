<!-- Block Modal -->
<!-- Add this at the end of your Blade file -->
<div class="modal fade" id="showBlockCaptainModal" tabindex="-1" aria-labelledby="blockCaptainModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blockCaptainModalLabel">{{ $data['captain']->name }} Block Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="datatable-container" class="table-responsive">
                    <table id="datatable" class="table table-hover table-sm table-bordered p-0" data-page-length="10" style="text-align: center">
                        <thead>
                            <tr>
                                <th>Block Reason</th>
                                <th>Created At</th>
                                <th>Call Center ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blocks as $block)
                                <tr>
                                    <td>{{$block->block_reason}}</td>
                                    <td>{{$block->call_center_name}}</td>
                                    <td>{{$block?->created_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Block Modal -->