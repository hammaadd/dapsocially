@extends('user.layout.userlayout')
@section('title','Home')
    

@section('content')
<div class="col-md-6 col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Horizontal Form</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form class="form form-horizontal" method="POST" action="{{route('add.event')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Event Name</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="vname" class="form-control"
                                    name="vname" placeholder="Event Name">
                            </div>
                            @error('vname')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                            <div class="col-md-4">
                                <label>Description</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <textarea type="text" id="description" class="form-control"
                                    name="description" placeholder="Description"></textarea>
                            </div>
                            @error('description')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror


                            <div class="col-md-4">
                                <label>Event Images</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="file" id="images[]" multiple class="form-control"
                                    name="image" placeholder="Image">
                            </div>
                            @error('image')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                            <div class="col-md-4">
                                <label>Location/City/Address</label>
                            </div>
                            <div class="col-md-8 form-group">
                            
                                <div class="input-group mb-3">
                                    <label class="input-group-text"
                                        for="inputGroupSelect01">Venue</label>
                                    <select class="form-select" id="address" name="address">
                                        @foreach ($locations as $location)
                                        
                                        <option value="{{$location->address}}">{{$location->address}}</option>
                                        @endforeach    
                                        
                                    </select>
                                </div>
                            </div>  
                            @error('address')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                            <div class="col-md-4">
                                <label>Hashtags</label>
                            </div>
                            <div class="col-md-8 form-group">
                                
                                <input id="hashtags" name="hashtags" required class="form-control" placeholder="hashtags" />
                            </div>
                            
                            @error('hashtags')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                            <div class="col-md-4">
                                <label>date and Time</label>
                            </div>
                            <div class="col-md-8 form-group">
                                
                                <input id="date_time" type="datetime-local" name="data_time" required  class="form-control" />
                            </div>
                                
                            @error('date_time')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                            
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="submit"
                                    class="btn btn-primary me-1 mb-1">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extrascripts')

@endsection

