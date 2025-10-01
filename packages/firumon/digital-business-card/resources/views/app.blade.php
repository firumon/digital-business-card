@extends(config('dbc.development') === "1" ? 'dbc::template.layout_dev' : 'dbc::template.layout')
@section('base')<base href="http://xnt:9000">
@stop
@section('vite')<script type="module" src="/@@vite/client"></script>
@stop
@section('title',$Individual->name . " :: " . $Company->name)
@push('script')

    <script src="{{ env('APP_URL') }}/script/{{ $code }}/{{ $Layout->updated_at->format('U') }}/Layout.js"></script>
    <script src="{{ env('APP_URL') }}/script/{{ $code }}/{{ $Company->updated_at->format('U') }}/Company.js"></script>
    <script src="{{ env('APP_URL') }}/script/{{ $code }}/{{ $Individual->updated_at->format('U') }}/Individual.js"></script>
    <script src="{{ env('APP_URL') }}/script/{{ \Firumon\DigitalBusinessCard\Models\Property::withoutGlobalScopes()->latest('updated_at')->first()->updated_at->format('U') }}/Property.js"></script>
@endpush
@php
    $FontPrimary = $Company->font_primary ?: $Layout->font_primary ?: null;
    $FontSecondary = $Company->font_secondary ?: $Layout->font_secondary ?: null;
    $BrandPrimary = $Company->brand_primary ?: null;
    $BrandSecondary = $Company->brand_secondary ?: null;
    $ColorPrimary = $Company->color_primary ?: null;
    $ColorSecondary = $Company->color_secondary ?: null;
@endphp

@pushif(($FontPrimary || $FontSecondary),'link')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
@endpushif
@pushif($FontPrimary,'link')

    <link href="https://fonts.googleapis.com/css2?family={{urlencode($FontPrimary)}}&display=swap" rel="stylesheet">
    <style> .font_primary { font-family: "{{$FontPrimary}}"; font-style: normal; }  body { font-family: '{{ $FontPrimary }}' } </style>
@endpushif
@pushif($FontSecondary,'link')

    <link href="https://fonts.googleapis.com/css2?family={{urlencode($FontSecondary)}}&display=swap" rel="stylesheet">
    <style> .font_secondary { font-family: "{{$FontSecondary}}"; font-style: normal; } </style>
@endpushif
@pushif(($BrandPrimary || $BrandSecondary || $ColorPrimary || $ColorSecondary),'link')

    <style> html:root { @if($BrandPrimary)--q-primary:{{ $BrandPrimary }}; @endif @if($BrandSecondary)--q-secondary:{{ $BrandSecondary }}; @endif }  @if($ColorPrimary).bg-primary{ color:{{ $ColorPrimary }}; } @endif @if($ColorSecondary).bg-secondary{ color:{{ $ColorSecondary }}; } @endif </style>
@endpushif
@push('append_body')
    <script type="module" src="/.quasar/dev-spa/client-entry.js"></script>
@endpush
