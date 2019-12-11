<link href="{{ asset('css/app.css') }}" rel="stylesheet">

@extends('layouts.app')

@section('content')

    <question-page :question='{{ $question }}'></question-page>

@endsection
