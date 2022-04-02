@php
    // $currantLang = $users->currentLanguage();
    $languages=\App\Models\Utility::languages();
    $footer_text=isset(\App\Models\Utility::settings()['footer_text']) ? \App\Models\Utility::settings()['footer_text'] : '';
    $header_text = (!empty(\App\Models\Utility::settings()['company_name'])) ? \App\Models\Utility::settings()['company_name'] : env('APP_NAME');
	$SITE_RTL = Cookie::get('SITE_RTL');
    
    if($SITE_RTL != 'on'){
        $SITE_RTL = 'off';
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{(\App\Models\Utility::getValByName('enable_rtl') == 'on') ? 'dir="rtl"' : ''}}>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') &dash; {{ config('app.name', 'TaskGo SaaS') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- <script src="{{ asset('assets/js/custom.js') }}"></script> --}}
    <link rel="icon" href="{{ asset(Storage::url('logo/favicon.png')) }}" type="image/png">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/site-light.css') }}" id="stylesheet">
    @if(\App\Models\Utility::getValByName('enable_rtl') == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-rtl.css') }}">
    @endif
</head>
<body class="application application-offset">
    <div class="container-fluid container-application">
            <div class="page-content">
                @if (trim($__env->yieldContent('title')) != 'Task Calendar')
                    <div class="page-title">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-xs-12 col-sm-12 col-md-4 d-flex align-items-center justify-content-between justify-content-md-start mb-3 mb-md-0">
                                <div class="d-inline-block">
                                    <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">@yield('title')</h5>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-8 d-flex align-items-center justify-content-between justify-content-md-end">
                                @yield('action-button')
                            </div>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
    </div>
    </body>

    <script src="{{asset('assets/js/site.core.js')}}"></script>
    <script src="{{asset('assets/js/site.js')}}"></script>