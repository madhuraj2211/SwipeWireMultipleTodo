@extends('master')
@section('content')
    <div class="container w-25 mt-5">
        <div class="d-flex justify-content-center card">
            <div class="row card-body">

                <div class="col-sm-12">

                    <form action="{{ route('login')}}" method="POST">
                        @csrf
                        <h2 class="title text-center mb-4">Login</h2>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li class="mx-3">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="email"
                                value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>

                        <div class="d-grid gap-2 col-3 mx-auto">
                            <button class="btn btn-primary mb-3">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
