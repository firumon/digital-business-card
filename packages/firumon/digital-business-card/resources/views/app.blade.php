@extends(config('dbc.development') === "1" ? 'dbc::template.layout_dev' : 'dbc::template.layout')
@section('base')<base href="http://localhost:9000">
@stop
@section('vite')<script type="module" src="/@@vite/client"></script>
@stop
@section('title',$data['company']['name'])
@push('script')
    const __DATA = {!! json_encode($data) !!}
@endpush
@push('append_body')
    <script type="module" src="/.quasar/dev-spa/client-entry.js"></script>
@endpush
