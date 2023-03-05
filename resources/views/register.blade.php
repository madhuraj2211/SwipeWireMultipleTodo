@extends('master')
@section('content')
    <div class = "container w-25 mt-5">
        <div class=" d-flex justify-content-center customer-login card">
            <div class="row card-body">
                <div class="col-sm">
                    <form action ="{{route('register')}}" method="POST">
                        @csrf
                        <h2 class="title text-center mb-4">Signup</h2>
                          @if ($errors->any())
                          <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li class="mx-3">{{$error}}</li>
                            @endforeach
                          </ul>
                          @endif
                        <div class="mb-3">
                            <label for="name" class="form-label">User Name</label>
                            <input type="text" name ="name" class="form-control" id="name" value={{ old('name')}}>
                            <div id="emailHelp" class="form-text"></div>
                          </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Email address</label>
                          <input type="email" name ="email" class="form-control" id="email" value={{ old('email')}}>
                        
                        </div>
                        <div class="mb-3">
                          <label for="password" class="form-label">Password</label>
                          <input type="password" name="password" class="form-control" id="password" value={{old('password')}}>
                        </div>
                        <div class="mb-3">
                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="confirmpassword" alue={{old('confirmpassword')}}>
                        </div>
                        <div class="d-grid gap-2 col-3 mx-auto">
                        
                          <button type="submit" class="btn btn-primary ">Register</button>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
@endsection