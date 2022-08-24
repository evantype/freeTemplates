@extends('layouts.app')

@section('content')

    <div class="container-xxl bd-gutter">
        <div class="row g-lg-5 mb-5">

            <div class="col">
                <div class="row">
                    @foreach($siteTemplates as $siteTemplate)
                        <div class="col-sm-6 col-md-4 mb-3">
                            <a class="d-block" href="{{ route('siteTemplate', ['slug' => $siteTemplate->slug]) }}">
                                <img class="img-thumbnail mb-3"
                                     src="{{ asset('storage/site_templates') . "/" . $siteTemplate->cover }}" alt=""
                                     width="480" height="300"
                                     loading="lazy">
                                <h3 class="h5 mb-1">{{ $siteTemplate->title }}</h3>
                            </a>
                            <p class="text-muted">Display your branding, navigation, search, and more with these header
                                components</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{ $siteTemplates->links() }}
        </div>
    </div>

@endsection
