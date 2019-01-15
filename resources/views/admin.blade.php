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

                    You are logged in as Admin Dashboard !  <br>

                    <a href="{{ route('admin.register') }}" class="w3-btn w3-white w3-border w3-border-red w3-round">Create Admin</a>

                    @if (count($admins)>0)
                    <h3> <strong> Admins</strong></h3> <br>
                    @foreach($admins as $admin) 
                    Id = {{$admin->id}} | Mail : {{$admin->email}}  <a href="{{ route('admin.edit', $admin->id) }}" class="w3-btn w3-white w3-border w3-border-red w3-round">Edit</a> -<a href="{{ route('admin.delete', $admin->id) }}" class="w3-btn w3-white w3-border w3-border-red w3-round">Delete</a> <br>
                    @endforeach
                    @endif



        </div>
    </div>
</div>
@endsection
