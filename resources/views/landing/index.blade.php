@extends('layouts.app')

@section('title', 'Higertech Karya Sinergi | Integrated Telemetry Solution & Internship Academy')

@section('content')
    <main>
        @include('landing.partials.hero')
        @include('landing.partials.workstation')
        @include('landing.partials.pillars')
        @include('landing.partials.map-section')
        @include('landing.partials.clients')
        @include('landing.partials.articles')
        @include('landing.partials.cta')
    </main>

    @include('landing.partials.footer')
@endsection
