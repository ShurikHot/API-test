@extends('layout')
@section('content')

<div class="row">
    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled list-mb0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
        @endif
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif
    </div>
</div>

<form class="mt-4" method="post" enctype="multipart/form-data">
    @csrf
    <label for="name">Name</label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{old('name')}}">
    <br>

    <label for="email">Email</label>
    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" value="{{old('email')}}">
    <br>

    <label for="phone">Phone</label>
    <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" id="phone" value="{{old('phone')}}">
    <br>

    <label for="position_id">Position</label>
    <select class="form-control @error('position_id') is-invalid @enderror" name="position_id" id="position_id">
        @foreach($positions as $id => $position)
            <option @if(old('position_id') == $id) selected @endif value="{{$id}}">{{$position}}</option>
        @endforeach
    </select>
    <br>

    <label for="photo">Photo</label>
    <input class="form-control @error('photo') is-invalid @enderror" type="file" name="photo" id="photo" value="{{old('photo')}}">
    <br>

    <button type="submit" class="btn btn-primary">Create new user</button>
</form>

<br>
<a href="{{route('users')}}"><button class="btn btn-secondary">User list</button></a>

@endsection
