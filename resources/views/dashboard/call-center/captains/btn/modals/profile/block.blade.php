<!-- Block Modal -->
<!-- Add this at the end of your Blade file -->
<div class="modal fade" id="blockCaptainModal" tabindex="-1" aria-labelledby="blockCaptainModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blockCaptainModalLabel">Block Captain</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="blockCaptainForm" method="POST" action="{{ route('CallCenterCaptains.block' ,$data['captain']?->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="captain_id" value="{{ $data['captain']->id }}">
                    <input type="hidden" name="callcenter_id" value="{{ get_user_data()->id }}">
                    <input type="hidden" name="status_captain_work" value="block">
                    <div class="form-group">
                        <label for="block_reason">Block Reason</label>
                        <textarea class="form-control" id="block_reason" name="block_reason" required></textarea>
                    </div>
                   <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Block</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Block Modal -->