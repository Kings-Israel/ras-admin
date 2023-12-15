@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <section class="content home">
        <div class="container-fluid">
            <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>{{ Str::title($page) }}</strong></h2>
                        </div>
                        <h1>Wing Details</h1>
                        <p>Name: {{ $wing->name }}</p>

                        <h2>Locations:</h2>
                        <ul>
                            @foreach($locations as $location)
                                <li>
                                    {{ $location->name }}

                                    {{-- Optional: Show associated shelves --}}
                                    @if ($location->shelves->isNotEmpty())
                                        <ul>
                                            @foreach ($location->shelves as $shelf)
                                                <li>{{ $shelf->name }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
