@extends('user.layout.userlayout')
@section('title','Order')
    
@section('content')

<div class="row match-height">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Check Out</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="POST" action="{{route('place.order')}}">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>First Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name" class="form-control"
                                                            name="fname" placeholder="First Name" value="{{Auth::user()->name}}">
                                                            <span class="ml-5 text-danger">@error('fname'){{ $message }}@enderror</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Email</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="email" id="email" class="form-control"
                                                            name="email" placeholder="Email" value="{{Auth::user()->email}}">
                                                            <span class="ml-5 text-danger">@error('email'){{ $message }}@enderror</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Mobile</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="contact-info" class="form-control"
                                                            name="contact" placeholder="Mobile" value="{{Auth::user()->mobile}}">
                                                            <span class="ml-5 text-danger">@error('contact'){{ $message }}@enderror</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Package</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="packages" class="form-control"
                                                            name="packages" placeholder="Premium" disabled>
                                                            <input type="text" id="package" class="form-control"
                                                            name="package" placeholder="Premium" hidden value="Premium">
                                                            
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Total amount</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="amounts" class="form-control"
                                                            name="amounts"  disabled value="{{$amount}}">
                                                            <input type="text" id="amount" class="form-control"
                                                            name="amount"   value="{{$amount}}" hidden>
                                                           
                                                    </div>
                                                    
                                                    <div class="col-sm-12 d-flex justify-content-end">
                                                        <button type="submit"
                                                            class="btn btn-primary me-1 mb-1">Place Order</button>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
@endsection                   