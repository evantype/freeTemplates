@extends('layouts.app')

@section('content')

    <div class="container px-4 pt-5 my-5 text-center border-bottom">
        <h1 class="display-4 fw-bold">{{ $template->title }}</h1>
        <div class="overflow-hidden mb-5" style="max-height: 30vh;">
            <div class="px-5">
                <img src="{{ asset('storage/site_templates') . "/" . $template->cover }}"
                     class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500"
                     loading="lazy">
            </div>
        </div>
        <div class="col-lg-6 mx-auto">
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                <a href="{{ $template->demo }}" class="btn btn-primary btn-lg px-4 me-sm-3" target="_blank">Demo</a>
            </div>
            <p class="lead mb-4">{{ $template->description }}</p>
        </div>
        <h3 class="h3">Links</h3>
        <blockquote class="blockquote">
            <ul class="list-group">
                @foreach(json_decode($template->download_links) as $downloadLink)
                    <li class="list-group-item">
                        <a href="{{ $downloadLink }}">{{ $downloadLink }}</a>
                    </li>
                @endforeach
            </ul>
        </blockquote>
    </div>
@endsection
