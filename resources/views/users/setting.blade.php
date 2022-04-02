@extends('layouts.admin')

@section('title')
    {{__('Site Settings')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 order-lg-2">
            <div class="card">
                <div class="list-group list-group-flush" id="tabs">
                    <div data-href="#tabs-1" class="list-group-item text-primary">
                        <div class="media">
                            <i class="fas fa-cog pt-1"></i>
                            <div class="media-body ml-3">
                                <a href="#" class="stretched-link h6 mb-1">{{__('Site Setting')}}</a>
                                <p class="mb-0 text-sm">{{__('Details about your personal information')}}</p>
                            </div>
                        </div>
                    </div>
                    <div data-href="#tabs-2" class="list-group-item">
                        <div class="media">
                            <i class="fas fa-envelope pt-1"></i>
                            <div class="media-body ml-3">
                                <a href="#" class="stretched-link h6 mb-1">{{__('Mailer Settings')}}</a>
                                <p class="mb-0 text-sm">{{__('Details about your mail setting information')}}</p>
                            </div>
                        </div>
                    </div>
                    <div data-href="#tabs-3" class="list-group-item">
                        <div class="media">
                            <i class="fas fa-comments pt-1"></i>
                            <div class="media-body ml-3">
                                <a href="#" class="stretched-link h6 mb-1">{{__('Pusher Settings')}}</a>
                                <p class="mb-0 text-sm">{{__('Details about your pusher setting information for chat')}}</p>
                            </div>
                        </div>
                    </div>
                    <div data-href="#tabs-4" class="list-group-item">
                        <div class="media">
                            <i class="fas fa-money-check-alt pt-1"></i>
                            <div class="media-body ml-3">
                                <a href="#" class="stretched-link h6 mb-1">{{__('ReCaptcha Settings')}}</a>
                                <p class="mb-0 text-sm">{{__('Test to tell human and bots apart by adding Recaptcha setting')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 order-lg-1">
            <div id="tabs-1" class="tabs-card">
                <div class="card">
                    <div class="card-header">
                        <h5 class="h6 mb-0">{{__('Basic Setting')}}</h5>
                    </div>
                    <div class="card-body">
                        {{ Form::open(['route' => ['settings.store'],'id' => 'update_setting','enctype' => 'multipart/form-data']) }}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('full_logo', __('Logo'),['class' => 'form-control-label']) }}
                                    <input type="file" name="full_logo" id="full_logo" class="custom-input-file"/>
                                    <label for="full_logo">
                                        <i class="fa fa-upload"></i>
                                        <span>{{__('Choose a file…')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pt-5">
                                <img src="{{ asset(Storage::url('logo/logo.png')) }}" class="img_setting"/>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('favicon', __('Favicon'),['class' => 'form-control-label']) }}
                                    <input type="file" name="favicon" id="favicon" class="custom-input-file"/>
                                    <label for="favicon">
                                        <i class="fa fa-upload"></i>
                                        <span>{{__('Choose a file…')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pt-5">
                                <img src="{{ asset(Storage::url('logo/favicon.png')) }}" class="img_setting"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('header_text', __('Title Text'),['class' => 'form-control-label']) }}
                                    {{ Form::text('header_text', $settings['header_text'], ['class' => 'form-control','placeholder' => __('Enter Header Title Text')]) }}
                                    {{-- {{ dd($settings['header_text']) }} --}}
                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('footer_text', __('Footer Text'),['class' => 'form-control-label']) }}
                                    {{ Form::text('footer_text', $settings['footer_text'], ['class' => 'form-control','placeholder' => __('Enter Footer Text')]) }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                   
                                    {{Form::label('default_language',__('Default Language'),['class'=>'form-control-label text-dark']) }}
                                    <select name="default_language" id="default_language" class="form-control select2">
                                        @foreach(Utility::languages() as $language)
                                            <option @if(Utility::getValByName('default_language') == $language) selected @endif value="{{$language}}">{{Str::upper($language)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{Form::label('timezone',__('Timezone'),['class'=>'form-control-label text-dark'])}}
                                    <select name="timezone" id="timezone" class="form-control select2">
                                        @foreach($timezones as $k => $timezone)
                                            <option value="{{$k}}" {{(env('TIMEZONE') == $k) ? 'selected':''}}>{{$timezone}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-lg-5">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="enable_landing" id="enable_landing" {{ (\App\Models\Utility::getValByName('enable_landing') == 'on') ? 'checked' : '' }}>
                                    <label class="custom-control-label form-control-label" for="enable_landing">{{__('Enable Landing Page')}}</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-lg-5">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="enable_rtl" id="enable_rtl" {{ (\App\Models\Utility::getValByName('enable_rtl') == 'on') ? 'checked' : '' }}>
                                    <label class="custom-control-label form-control-label" for="enable_rtl">{{__('Enable RTL')}}</label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-lg-5">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input gdpr_fulltime gdpr_type" name="gdpr_cookie" id="gdpr_cookie" {{ isset($settings['gdpr_cookie']) && $settings['gdpr_cookie'] == 'on' ? 'checked="checked"' : '' }}> 
                                    <label class="custom-control-label form-control-label" for="gdpr_cookie">{{ __('GDPR Cookie') }}</label>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mt-lg-5">
                                <div class="custom-control custom-switch">
                                    {{-- {{ dd(\App\Models\Utility::getValByName('SIGNUP')) }} --}}
                                    <input type="checkbox" class="custom-control-input" name="SIGNUP" id="SIGNUP" {{ isset($settings['SIGNUP']) && $settings['SIGNUP'] == 'on' ? 'checked="checked"' : '' }}> 
                                    <label class="custom-control-label form-control-label" for="SIGNUP">{{ __('SIGNUP') }}</label>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('footer_link_1', __('Footer Link Title 1'),['class' => 'form-control-label']) }}
                                    {{ Form::text('footer_link_1', \App\Models\Utility::getValByName('footer_link_1'), ['class' => 'form-control','required'=>'required','placeholder' => __('Enter Footer Link Title 1')]) }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('footer_value_1', __('Footer Link href 1'),['class' => 'form-control-label']) }}
                                    {{ Form::text('footer_value_1', \App\Models\Utility::getValByName('footer_value_1'), ['class' => 'form-control','required'=>'required','placeholder' => __('Enter Footer Link 1')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('footer_link_2', __('Footer Link Title 2'),['class' => 'form-control-label']) }}
                                    {{ Form::text('footer_link_2', \App\Models\Utility::getValByName('footer_link_2'), ['class' => 'form-control','required'=>'required','placeholder' => __('Enter Footer Link Title 2')]) }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('footer_value_2', __('Footer Link href 2'),['class' => 'form-control-label']) }}
                                    {{ Form::text('footer_value_2', \App\Models\Utility::getValByName('footer_value_2'), ['class' => 'form-control','required'=>'required','placeholder' => __('Enter Footer Link 2')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('footer_link_3', __('Footer Link Title 3'),['class' => 'form-control-label']) }}
                                    {{ Form::text('footer_link_3', \App\Models\Utility::getValByName('footer_link_3'), ['class' => 'form-control','required'=>'required','placeholder' => __('Enter Footer Link Title 3')]) }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('footer_value_3', __('Footer Link href 3'),['class' => 'form-control-label']) }}
                                    {{ Form::text('footer_value_3', \App\Models\Utility::getValByName('footer_value_3'), ['class' => 'form-control','required'=>'required','placeholder' => __('Enter Footer Link 3')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            {{ Form::hidden('from','site_setting') }}
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div id="tabs-2" class="tabs-card d-none">
                <div class="card">
                    <div class="card-header">
                        <h5 class="h6 mb-0">{{__('Mailer Settings')}}</h5>
                    </div>
                    <div class="card-body">
                        {{ Form::open(['route' => ['settings.store'],'id' => 'update_setting']) }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_driver', __('Mail Driver'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_driver', env('MAIL_DRIVER'), ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Driver')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_host', __('Mail Host'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_host', env('MAIL_HOST'), ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Host')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_port', __('Mail Port'),['class' => 'form-control-label']) }}
                                    {{ Form::number('mail_port', env('MAIL_PORT'), ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Port'),'min' => '0']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_username', __('Mail Username'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_username', env('MAIL_USERNAME'), ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Username')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_password', __('Mail Password'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_password', env('MAIL_PASSWORD'), ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Password')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_encryption', __('Mail Encryption'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_encryption', env('MAIL_ENCRYPTION'), ['class' => 'form-control','required'=>'required','placeholder' => __('Mail Encryption')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_from_address', __('Mail From Address'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_from_address', env('MAIL_FROM_ADDRESS'), ['class' => 'form-control','required'=>'required','placeholder' => __('Mail From Address')]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('mail_from_name', __('Mail From Name'),['class' => 'form-control-label']) }}
                                    {{ Form::text('mail_from_name', env('MAIL_FROM_NAME'), ['class' => 'form-control','required'=>'required','placeholder' => __('Mail From Name')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="text-left">
                                    <button type="button" class="btn btn-sm btn-warning rounded-pill send_email" data-title="{{__('Send Test Mail')}}" data-url="{{route('test.email')}}">{{__('Send Test Mail')}}</button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-right">
                                    {{ Form::hidden('from','mail') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div id="tabs-3" class="tabs-card d-none">
                <div class="card">
                    <div class="card-header">
                        <h5 class="h6 mb-0">{{__('Pusher Settings')}}</h5>
                    </div>
                    <div class="card-body">
                        {{ Form::open(['route' => ['settings.store'],'id' => 'update_setting']) }}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('pusher_app_id', __('Pusher App Id'),['class' => 'form-control-label']) }}
                                    {{ Form::text('pusher_app_id', env('PUSHER_APP_ID'), ['class' => 'form-control','required'=>'required','placeholder' => __('Pusher App Id')]) }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('pusher_app_key', __('Pusher App Key'),['class' => 'form-control-label']) }}
                                    {{ Form::text('pusher_app_key', env('PUSHER_APP_KEY'), ['class' => 'form-control','required'=>'required','placeholder' => __('Pusher App Key')]) }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('pusher_app_secret', __('Pusher App Secret'),['class' => 'form-control-label']) }}
                                    {{ Form::text('pusher_app_secret', env('PUSHER_APP_SECRET'), ['class' => 'form-control','required'=>'required','placeholder' => __('Pusher App Secret')]) }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('pusher_app_cluster', __('Pusher App Cluster'),['class' => 'form-control-label']) }}
                                    {{ Form::text('pusher_app_cluster', env('PUSHER_APP_CLUSTER'), ['class' => 'form-control','required'=>'required','placeholder' => __('Pusher App Cluster')]) }}
                                </div>
                            </div>
                            <div class="col-12">
                                <small><a href="https://pusher.com/channels" target="_blank">{{__('You can Make Pusher channel Account from here and Get your App Id and Secret key')}}</a></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-right">
                                    {{ Form::hidden('from','pusher') }}
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">{{__('Save changes')}}</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div id="tabs-4" class="tabs-card d-none">
                <div class="card">
                    <div class="card-header">
                        <h5 class="h6 mb-0">{{__('ReCaptcha Settings')}}</h5>
                        <small>{{__('Test to tell human and bots apart by adding Recaptcha setting.')}}</small>
                    </div> 
                    <div id="recaptcha-settings" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    {{-- <h4 class="h4 font-weight-400 float-left pb-2">{{ __('ReCaptcha settings') }}</h4> --}}
                                </div>
                            </div>
                            <div class="p-3">
                                <form method="POST" action="{{ route('recaptcha.settings.store') }}" accept-charset="UTF-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="recaptcha_module" id="recaptcha_module" value="yes" {{ env('RECAPTCHA_MODULE') == 'yes' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label form-control-label" for="recaptcha_module">
                                                    {{ __('Google Recaptcha') }}
                                                    <a href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/" target="_blank" class="text-blue">
                                                        <small>({{__('How to Get Google reCaptcha Site and Secret key')}})</small>
                                                    </a>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="google_recaptcha_key" class="form-control-label">{{ __('Google Recaptcha Key') }}</label>
                                            <input class="form-control" placeholder="{{ __('Enter Google Recaptcha Key') }}" name="google_recaptcha_key" type="text" value="{{env('NOCAPTCHA_SITEKEY')}}" id="google_recaptcha_key">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="google_recaptcha_secret" class="form-control-label">{{ __('Google Recaptcha Secret') }}</label>
                                            <input class="form-control " placeholder="{{ __('Enter Google Recaptcha Secret') }}" name="google_recaptcha_secret" type="text" value="{{env('NOCAPTCHA_SECRET')}}" id="google_recaptcha_secret">
                                        </div>
                                    </div>
                                    <div class="col-lg-12  text-right">
                                        <input type="submit" value="{{ __('Save Changes') }}" class="btn btn-sm btn-primary rounded-pill">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // For Sidebar Tabs
        $(document).ready(function () {
            $('.list-group-item').on('click', function () {
                var href = $(this).attr('data-href');
                $('.tabs-card').addClass('d-none');
                $(href).removeClass('d-none');
                $('#tabs .list-group-item').removeClass('text-primary');
                $(this).addClass('text-primary');
            });
        });

        // For Test Email Send
        $(document).on("click", '.send_email', function (e) {
            e.preventDefault();
            var title = $(this).attr('data-title');
            var size = 'md';
            var url = $(this).attr('data-url');
            if (typeof url != 'undefined') {
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $("#commonModal").modal('show');

                $.post(url, {
                    mail_driver: $("#mail_driver").val(),
                    mail_host: $("#mail_host").val(),
                    mail_port: $("#mail_port").val(),
                    mail_username: $("#mail_username").val(),
                    mail_password: $("#mail_password").val(),
                    mail_encryption: $("#mail_encryption").val(),
                    mail_from_address: $("#mail_from_address").val(),
                    mail_from_name: $("#mail_from_name").val(),
                }, function (data) {
                    $('#commonModal .modal-body').html(data);
                });
            }
        });
        $(document).on('submit', '#test_email', function (e) {
            e.preventDefault();
            $("#email_sanding").show();
            var post = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: "post",
                url: url,
                data: post,
                cache: false,
                success: function (data) {
                    if (data.is_success) {
                        show_toastr('Success', data.message, 'success');
                    } else {
                        show_toastr('Error', data.message, 'error');
                    }
                    $("#email_sanding").hide();
                }
            });
        })
    </script>
      <script>
    $(document).ready(function () {
            if ($('.gdpr_fulltime').is(':checked') ) {

                $('.fulltime').show();
            } else {

                $('.fulltime').hide();
            }

        $('#gdpr_cookie').on('change', function() {
            if ($('.gdpr_fulltime').is(':checked') ) {

                $('.fulltime').show();
            } else {

                $('.fulltime').hide();
            }
        });
    });

</script>
@endpush
