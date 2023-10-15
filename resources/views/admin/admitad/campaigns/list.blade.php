@extends('admin.layout.app')
@section('title', 'Admitad Campaign List')

@push('css_or_js')
    <style>
        .flex.justify-between.flex-1.sm\:hidden {
            display: none;
        }

        p.text-sm.text-gray-700.leading-5 {
            display: none;
        }

        svg.w-5.h-5 {
            width: 22px !important;
        }

        h5 {
            width: 100% !important;
        }

        a.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-700.bg-white.border.border-gray-300.leading-5.hover\:text-gray-500.focus\:z-10.focus\:outline-none.focus\:ring.ring-gray-300.focus\:border-blue-300.active\:bg-gray-100.active\:text-gray-700.transition.ease-in-out.duration-150 {
            margin: 3px;
            padding: 9px !important;
        }



        span.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5 {
            background-color: blue !important;
            color: white;
            margin: 3px;
            padding: 10px !important;
        }
    </style>
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h2 class="page-title" align="left" style="width: 100%;">
                        Admitad Campaign List

                    </h2>
                    <div class="flex">
                        <form id="dataSearch">
                            @csrf
                            <!-- Search -->
                            <div class="d-flex fluid">
                                <input type="search" name="search" class="form-control" placeholder="Search Campaigns"
                                    aria-label="search advertisers">
                                &nbsp;<button type="submit" class="btn btn-success">Search</button>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>&nbsp;
                    <a align="right" style="float:right !important;"
                        href="{{ route('admin.admitadcampaigns.export-all') }}" class="btn btn-danger  float-right">Export
                        All </a>&nbsp;
                </div>
                <div class="card-body">
                    <div class="table">
                        <table id="example" class="display table-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th><button class="table-sort" data-sort="sort-s">#</button></th>
                                    <th><button class="table-sort" data-sort="sort-image"> Name</button></th>
                                    <th><button class="table-sort" data-sort="sort-image">Image</button></th>
                                    <th><button class="table-sort" data-sort="sort-image">Description</button></th>
                                    <th><button class="table-sort" data-sort="sort-image">Advertiser</button></th>
                                    <th><button class="table-sort" data-sort="sort-image">Category</button></th>
                                    <th><button class="table-sort" data-sort="sort-image">Status</button></th>
                                    <th><button class="table-sort" data-sort="sort-name">Added On</button></th>
                                    <th><button class="table-sort" data-sort="sort-type">Action</button></th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody">
                                @foreach ($em as $k => $e)
                                    <tr>
                                        <td scope="row">{{ $k + $em->firstItem() }}</td>
                                        <td class="sort-name"> {{ $e['name'] }}</td>
                                        <td class="sort-name">
                                            @if ($e['image'] != null)
                                                <img src="{{ asset('storage/app/public/offer') }}/{{ $e['image'] }}"
                                                    alt="no image" style="width:80px"><br><br>
                                            @endif
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#exampleModal{{ $e->id }}">
                                                Change Image</button>
                                        </td>
                                        <td class="sort-name">
                                            @if ($e['description'] == null)
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#exampl2eModal{{ $e->id }}">
                                                    Add Description</button>
                                            @else
                                                <p>{{ Str::limit($e['description'], 60) }}</p>
                                            @endif
                                        </td>
                                        <td class="sort-name">
                                            @if ($e['partner'] != null)
                                                {{ Str::limit($e['partner']['name'], 30) }}
                                            @else
                                                <span style="color:red">Partner Not Available</span>
                                            @endif
                                        </td>
                                        <td class="sort-name">{{ $e['category']['name'] }} </td>

                                        <td style="">
                                            <label class="form-check form-check-single form-switch"
                                                for="stocksCheckbox{{ $e->id }}">
                                                <input type="checkbox" class="form-check-input"
                                                    onclick="myFunction{{ $e->id + 1 }}()"
                                                    id="stocksCheckbox{{ $e->id }}" {{ $e->status ? 'checked' : '' }}>
                                            </label>
                                            <script>
                                                function myFunction{{ $e->id + 1 }}() {
                                                    if (window.confirm('Do you want to change the Status ?')) {
                                                        window.location.href = "{{ route('admin.admitadcampaigns.status', [$e->id, $e->status ? 0 : 1]) }}"
                                                    }
                                                }
                                            </script>
                                        </td>
                                        <?php $date = date_format($e['created_at'], 'd-M-Y'); ?>
                                        <td class="sort-name"> {{ $date }}</td>
                                        <td class="sort-type">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle align-text-top"
                                                    data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.admitadcampaigns.edit', $e['id']) }}"
                                                        title="Edit Campaign">Edit Categorie
                                                    </a>
                                                    <a href="{{ route('admin.admitadcampaigns.delete', $e['id']) }}"
                                                        class="dropdown-item" href="javascript:"
                                                        onclick="return confirm('Are you sure?');"
                                                        title="Delete Campaign">Delete
                                                    </a>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer" align="right">
                    <div class="pull-right mb-1" style="float: right;">
                        {{ $em->render('pagination::bootstrap-4') }}
                    </div>


                </div>
            </div>
        </div>
    </div>

    @foreach ($em as $k => $e)
        <div class="modal fade" id="exampleModal{{ $e->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel{{ $e->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.admitadcampaigns.update_cam_img', $e->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel{{ $e->id }}" align="left">Add Banner
                                Image</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                align="right">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" id="viewerbox" style="display:none;margin-bottom:0%;">
                                <center>
                                    <img style="width: 200px;border: 1px solid #3399db; border-radius: 10px; max-height:200px; padding: 11px;"
                                        id="viewer" src="{{ asset('storage/app/public/offer') }}/{{ $e['image'] }}"
                                        alt="offer banner" />
                                </center>
                            </div>

                            <div class="mb-3">
                                <div class="form-label">Campaigns Banner <small style="color: red">* (ratio=> 1:1)</small>
                                </div>
                                <input type="file" name="image" id="customFileEg1" class="form-control"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" />
                                <label class="custom-file-label" for="customFileEg1"></label>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Description -->
        <div class="modal fade" id="exampl2eModal{{ $e->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel{{ $e->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.admitadcampaigns.update_desc', $e->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example2ModalLabel{{ $e->id }}" align="left">Add
                                Description</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                align="right">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label required">Description</label>
                                <textarea class="form-control" name="description" id="summernote">{{ $e['description'] }}</textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

@endsection


@push('script_2')
    <script>
        function getStoreData(route, store_id, id) {
            $.get({
                url: route + store_id,
                dataType: 'json',
                success: function(data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        function getRequest(route, id) {
            $.get({
                url: route,
                dataType: 'json',
                success: function(data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                    document.getElementById("image-viewer-section").style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
            $('#image-viewer-section').show(1000);
        });
    </script>


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
                    url: '{{ route('admin.category.search') }}',
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
                    url: '{{ route('admin.category.search') }}',
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
