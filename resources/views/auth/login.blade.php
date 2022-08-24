@extends('layouts.app')
@section('content')


<section class="vh-100" style="background-color: #508bfc;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-5">Sign in</h3>
            @if(Session::has('error'))
            <p class="text-danger">{{Session :: get('error')}}</p>
            @endif
            @if(session:: has ('success'))
            <p class="text-success">{{Session::get('success')}}</p>
            @endif
            <form action="{{route('login')}}" method="post">
              @csrf
              <div class="form-outline mb-4">
                <label class="form-label" for="form2Example1">Email address</label>
                <input type="email" id="form2Example1" name="email" class="form-control" />
                @if($errors->has('email'))
                <p class="text-danger">{{$errors->first('email')}}</p>
                @endif

              </div>

              <!-- Password input -->
              <div class="form-outline mb-4">
                <label class="form-label" for="form2Example2">Password</label>
                <input type="password" id="form2Example2" name="password" class="form-control" />
                @if($errors->has('password'))
                <p class="text-danger">{{$errors->first('password')}}</p>
                @endif
              </div>

              <!-- 2 column grid layout for inline styling -->
              <div class="row mb-4">
                <div class="col d-flex justify-content-center">
                  <!-- Checkbox -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                    <label class="form-check-label" for="form2Example31"> Remember me </label>
                  </div>
                </div>

                <div class="col">
                  <!-- Simple link -->
                  <a href="{{route('forget-password')}}">Forgot password?</a>
                </div>
              </div>

              <!-- Submit button -->
              <input type="submit" class="btn btn-primary btn-block mb-4" value="login">

              <!-- Register buttons -->
              <div class="text-center">
                <p>Not a member? <a href="{{route('register')}}">Register</a></p>

              </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection