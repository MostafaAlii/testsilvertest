<div class="modal fade" id="create{{ $data['title'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('general.create') .' '. $data['title'] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('callCenters.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Start Name -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" required name="name" id="name" value="">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Name -->

                    <!-- Start Email -->
                    <div class="form-group">
                        <label for="email">{{ trans('admins.email') }}</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Email -->

                    <!-- Start Phone -->
                    <div class="form-group">
                        <label for="phone">{{ trans('admins.phone') }}</label>
                        <input type="number" class="form-control" required name="phone" id="phone">
                        @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Phone -->
                    <!-- Start Country Selected -->
                    <div class="form-group p-1">
                        <label for="country_id">Country</label>
                        <select name="country_id" class="form-control">
                            <option selected disabled>Select {{$data['title']}} Country...</option>
                            @forelse ($data['countries'] as $country)
                            <option value="{{$country->id}}" {{ old('country_id')==$country->id ? 'selected' : '' }}>{{
                                $country->name }}
                            </option>
                            @empty
                            <option value="0">No Countries</option>
                            @endforelse
                        </select>
                        @error('country_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Country Selected -->
                    <!-- Start Status Status -->
                    <div class="form-group p-1">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option selected disabled>Select {{$data['title']}} Status...</option>
                            <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>{{
                                trans('general.active') }}</option>
                            <option value="inactive" {{ old('status')=='inactive' ?'selected' : '' }}>{{
                                trans('general.inactive') }}</option>
                        </select>
                        @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Status Selected -->

                    <!-- Start Type -->
                    <div class="form-group p-1">
                        <label for="type">Type</label>
                        <select name="type" class="form-control">
                            <option selected disabled>Select {{$data['title']}} Type...</option>
                          @if(auth('admin')->check())
                                <option value="manager" {{ old('type')=='manager' ? 'selected' : '' }}>
                                    Manager
                                </option>
                          @endif

                            <option value="callcenter" {{ old('type')=='callcenter' ?'selected' : '' }}>
                                Call-Center
                            </option>
                        </select>
                        @error('type')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Type Selected -->

                    <!-- Start Password -->
                    <div class="form-group p-1">
                        <label for="password">{{ trans('admins.password') }}</label>
                        <input type="password" class="form-control" required name="password" id="password">
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Password -->


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
