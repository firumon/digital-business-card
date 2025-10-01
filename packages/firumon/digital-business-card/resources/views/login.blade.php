@extends(config('dbc.development') === "1" ? 'dbc::template.layout_dev' : 'dbc::template.layout')
@section('base')<base href="http://xnt:9000">
@stop
@section('vite')<script type="module" src="/@@vite/client"></script>
@stop
@section('title','xnture :: Digital Business Card')
@push('meta')<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('script_content')const LOGIN_URL = '{{ route('login') }}';@endpush
@push('append_body')
    <script type="module" src="/.quasar/dev-spa/client-entry.js"></script>
@endpush
