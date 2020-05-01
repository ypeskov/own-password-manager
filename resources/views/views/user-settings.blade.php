@extends('layouts.main')

@section('content')
    <settings-container user="{{ $user }}" tab="{{ $tab }}"></settings-container>
@endsection
