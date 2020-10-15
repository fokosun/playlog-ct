@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            @include('components.comments.create')
        </div>
        <div>
            @include('components.comments.view')
        </div>
    </div>
@endsection