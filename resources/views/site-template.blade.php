@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="p-4 p-md-5 mb-4 rounded text-bg-dark row">
            <div class="col-md-6 px-0">
                <h1 class="display-4 mb-3">{{ $template->title }}</h1>
                <a href="{{ $template->demo }}" class="btn btn-primary btn-lg px-4 me-sm-3" target="_blank">Посмотреть
                    демо</a>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('storage/site_templates') . "/" . $template->cover }}"
                     class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500"
                     loading="lazy">

            </div>
        </div>
        <div class="row g-5">
            <div class="col-md-8">
                <article>
                    <div class="mb-1 h3 card-title">Описание</div>
                    <p class="card-text">{{ $template->description }}</p>
                </article>
                <div class="mt-3">
                    <div class="h3 card-title">Ссылки для скачивания</div>
                    <p class="card-text ">Вы можете скачать абсолютно легально и бесплатно данный шаблон. Он
                        находится в открытом доступе. Вы можете воспользоваться им как угодно. Если у Вас возникли
                        проблемы с установкой шаблонов или натяжкой их на движок, доработкой и кастомизацией, то наша
                        команда специалистов с радостью поможет Вам.</p>
                    <blockquote class="blockquote mt-3">
                        <ul class="list-group">
                            @foreach(json_decode($template->download_links) as $downloadLink)
                                <li class="list-group-item">
                                    <a class="link-dark" style="font-size: 1rem" href="{{ $downloadLink }}">{{ $downloadLink }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </blockquote>
                </div>
                <div class="mt-3">

                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span class="text-muted">Добавлено: {{ $template->updated_at }}</span>
                    <span class="text-muted">Обновлено: {{ $template->created_at }}</span>
                </div>
            </div>

            @include('partitials.rightbar')
        </div>
    </div>
@endsection
