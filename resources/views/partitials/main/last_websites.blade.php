<div class="container px-4 py-5" id="custom-cards">
    <h2 class="pb-2 border-bottom">Недавно добавленные шаблоны сайтов</h2>

    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
        @foreach($siteTemplates as $siteTemplate)

            <div class="col">
                <a href="{{ route('siteTemplate', ['slug' => $siteTemplate->slug]) }}">
                    <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg"
                         style="background-image: url({{ asset('storage/site_templates') . "/" . $siteTemplate->cover }});">
                        <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                            <h2 class="opacity-0 pt-5 mt-5 mb-4 lh-1 fw-bold">{{ $siteTemplate->title }}</h2>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="text-center">
        <a href="{{ route('siteTemplates') }}" class="btn btn-lg btn-success ">Смотреть еще</a>
    </div>
</div>
