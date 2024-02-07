<div class="modal fade" id="create_hour" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('general.create') .' '. $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('hours.store')}}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Start Number Hours -->
                        <div class="col-4">
                            <div class="form-group">
                                <label for="number_hours">Number Hours</label>
                                <input type="text" class="form-control" name="number_hours" id="number_hours" value="">
                                @error('number_hours')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- End Number Hours -->

                        <!-- Start Offer Price -->
                        <div class="col-4">
                            <div class="form-group">
                                <label for="offer_price">Offer Price</label>
                                <input type="text" class="form-control" name="offer_price" id="offer_price" value="">
                                @error('offer_price')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- End Offer Price -->

                        <!-- Start Discount Hours -->
                        <div class="col-4">
                            <div class="form-group">
                                <label for="discount_hours">Discount Hours</label>
                                <input type="text" class="form-control" name="discount_hours" id="discount_hours" value="">
                                @error('discount_hours')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- End Discount Hours -->
                    </div>

                    <div class="row">
                        <!-- Start Price Hours -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price_hours">Price Hours</label>
                                <input type="text" class="form-control" name="price_hours" id="price_hours" value="">
                                @error('price_hours')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- End Price Hours -->

                        <!-- Start Price Premium -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price_premium">Price Premium</label>
                                <input type="text" class="form-control" name="price_premium" id="price_premium" value="">
                                @error('price_premium')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- End Price Premium -->
                    </div>

                    <div class="row">
                        <!-- Start Offer  Price Premium -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="offer_price_premium">Offer Price Premium</label>
                                <input type="text" class="form-control" name="offer_price_premium" id="offer_price_premium" value="">
                                @error('offer_price_premium')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- End Offer Price Premium -->

                        <div class="col-6">
                            <label for="category_car_id">Category</label>
                            <select name="category_car_id" class="p-1 form-control">
                                <option selected disabled>Select Hour...</option>
                                @foreach(CategoryCar::latest()->get() as $category)
                                <option value="{{$category->id}}">
                                    {{$category->name}}
                                </option>
                                @endforeach
                            </select>
                            @error('category_car_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>



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