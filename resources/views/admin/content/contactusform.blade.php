@extends('admin.layout.adminlayout')
@section('title', 'Add Roles')

@section('content')
<div class="m-5">
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Horizontal Form</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form class="form form-horizontal" action="{{route('add.message')}}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>First Name</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="fname" class="form-control"
                                name="fname" placeholder="Name">
                        </div>
                        <div class="col-md-4">
                            <label>Email</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="email" id="email-id" class="form-control"
                                name="mail" placeholder="Email">
                        </div>
                        <div class="col-md-4">
                            <label>Mobile</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="contact-info" class="form-control"
                                name="contact" placeholder="Mobile">
                        </div>
                        <div class="col-md-4">
                            <label>Message</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="message" class="form-control"
                                name="message" placeholder="Message">
                        </div>
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