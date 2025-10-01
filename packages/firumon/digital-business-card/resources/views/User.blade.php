@extends(config('dbc.development') === "1" ? 'dbc::template.layout_dev' : 'dbc::template.layout')
@section('base')<base href="http://xnt:9000">
@stop
@section('vite')<script type="module" src="/@@vite/client"></script>
@stop
@push('meta')<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('title','DBC :: '.(\Illuminate\Support\Facades\Auth::user()->role).' Portal')
@push('script_content')const LOGOUT_URL = '{{ route('logout') }}';@endpush
@push('append_body')
    <script type="module" src="/.quasar/dev-spa/client-entry.js"></script>
@endpush
