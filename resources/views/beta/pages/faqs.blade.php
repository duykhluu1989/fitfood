@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    @include('beta.layouts.partials.header', ['banner' => asset('assets/images/page-header/faq.jpg'), 'title' => 'Faq'])

    <div class="container">
        <div class="row">
            <div id="primary" class="full-width row">
                <div id="content" class="box-shadow">
                    <div class="wrap-faq">

                        @include('beta.layouts.partials.language')

                        <div class="page-title">
                            <h2>@lang('faqs_page.faq')</h2>
                            <p class="description">@lang('faqs_page.faqText')</p>
                        </div>

                        @if(App::getLocale() == 'en')
                            @include('beta.pages.partials.faqs_body_en')
                        @else
                            @include('beta.pages.partials.faqs_body_vi')
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop