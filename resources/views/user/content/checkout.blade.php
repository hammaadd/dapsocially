@extends('user.layout.userlayout')
@section('title','Check Out')
    
@section('content')
<a href="{{route('payment.details')}}"><button type="button" class="btn btn-outline-danger">Cancel</button></a>
<a href="{{route('payment.processing',['id'=>$data['id'],'total_payment'=>$data['total_payment']])}}"><button type="button" class="btn btn-outline-success" >Check Out</button></a>



@endsection 