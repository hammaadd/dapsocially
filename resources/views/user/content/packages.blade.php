@extends('user.layout.userlayout')
@section('title','Order')
    
@section('content')

<div class="row">
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <h5 class="card-title">$99 per year</h5>
          <a href="{{route('order.details',99)}}" class="btn btn-primary">Check Out</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
          <h5 class="card-title">$79 per month</h5>
          <a href="{{route('order.details',79)}}" class="btn btn-primary">Check Out</a>
        </div>
      </div>
    </div>
  </div>
 @endsection 