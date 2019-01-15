@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        
                     Users!  <br>

                    <a href="{{ route('admin.user.register') }}" class="w3-btn w3-white w3-border w3-border-red w3-round">Create User</a>

                    @if (count($users)>0)
                    <h3> <strong> Admin Panel</strong></h3> <br>
                    @foreach($users as $user) 
                    Id = {{$user->id}} | Mail : {{$user->email}}  <a href="{{ route('admin.login.as.user', $user->id) }}" class="w3-btn w3-white w3-border w3-border-red w3-round">Login as User</a> - <a href="{{ route('admin.delete.user', $user->id) }}" class="w3-btn w3-white w3-border w3-border-red w3-round">Delete</a> <br> 
                    @endforeach
                    @endif



        </div>
    </div>
</div>
@endsection
