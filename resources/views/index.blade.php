@extends('layout')
@section('content')

    <div class="users mt-4">
        <?php
        if (isset($users)) {
            foreach ($users as $user) {

                echo $user['name'] . '<br>';
            }
        }
        ?>
    </div>
    <div class="mb-2">
        {{$users->links('vendor.pagination.simple-bootstrap-5')}}
    </div>

    <a href="{{route('create')}}"><button class="btn btn-primary">Create new user</button></a>

@endsection
