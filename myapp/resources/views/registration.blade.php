@extends('layout')
@section('title', 'Registration')
@section('content')

<div class="container">
    <form action ="{{route('registration.post')}}" method="POST" class="ms-auto me-auto mt-3" style="width: 500px">
        @csrf

        <div class="mb-3">
            <label class="form-label">Full name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

{{-- Display validation errors --}}
@if($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Display success message --}}
@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

{{-- Display error message --}}
@if (session('error'))
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
@endif

@endsection
