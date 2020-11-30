@extends('layouts.base')

@section('template-css')
    <link href="{{ mix('css/front.css') }}" rel="stylesheet">
@endsection

@section('body')
    <Frontend/>
@endsection

@section('template-js')
    <script src="{{ mix('js/frontend.js') }}"></script>
@endsection
