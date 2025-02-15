@section('header')
    <link href="{{ asset('vendor/pickadate/themes/default.date.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/pickadate/themes/default.time.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/pickadate/themes/default.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">

@endsection


@section('footer')
    <script src="{{ asset('vendor/pickadate/picker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/picker.date.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/picker.time.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/pickadate/legacy.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>

    <script type="text/javascript">

        $('#user_id').select2({
            placeholder: "@lang('saas.search')...",
            minimumInputLength: 3,
            ajax: {
                url: '{{ route('admin.subscribers.search') }}',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }

        });

        $('.date').pickadate({
            format: 'yyyy-mm-dd'
        });

        function toogleOptions(){

            if($('#invoice_purpose_id').val()=='1'){
                $('.item').show();
                console.log('not free');
            }
            else{
                $('.item').hide();
                console.log('is free');
            }
        }

        $(function(){
            toogleOptions();
            $('#invoice_purpose_id').change(function(){
                toogleOptions();
            })
        })
    </script>
@endsection