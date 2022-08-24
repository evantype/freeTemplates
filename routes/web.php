<?php

use App\Http\Controllers\MainPageController;
use App\Http\Controllers\SiteTemplateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainPageController::class, 'index'])->name('mainPageIndex');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('site-templates', [SiteTemplateController::class, 'listTemplates'])->name('siteTemplates');

Route::get('site-templates/{slug}', [SiteTemplateController::class, 'template'])->name('siteTemplate');
