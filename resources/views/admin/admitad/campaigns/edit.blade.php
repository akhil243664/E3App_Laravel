@extends('admin.layout.app')
@section('title', 'Update Campaign')

@push('css_or_js')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h2 class="page-title">
                        Campaign Categorie Update
                    </h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.admitadcampaigns.update', [$campain['id']]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label required">Campaign Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $campain['name'] }}" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Categories</label>
                            <select class="form-control" name="category_id" id="categories">
                                <option value="{{ $category !== null ? $category->id : '' }}">
                                    {{ $category !== null ? $category->name : 'Choose a Category' }}
                                </option>
                                @foreach ($categorys as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection


@push('script_2')
    <script>
        $(document).on('ready', function() {
            // INITIALIZATION OF DATATABLES
            // =======================================================


            $('#dataSearch').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{ route('admin.advertiser.search') }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(data) {
                        $('#table-div').html(data.view);
                        $('#itemCount').html(data.count);
                        $('.page-area').hide();
                    },
                    complete: function() {
                        $('#loading').hide();
                    },
                });
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                    document.getElementById("viewerbox").style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
        });
    </script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('public/theme_assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/theme_assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
@endpush
