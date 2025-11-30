@extends('layouts.backend.app')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $sub_title }}</h3>
                            <div class="card-options align-items-center">
                                <button class="btn btn-success btn-tags"><i class="fa fa-plus"></i> Tags</button>
                                <button class="btn btn-warning btn-category mx-2"><i class="fa fa-plus"></i>
                                    Category</button>
                                <button class="btn btn-primary btn-add"><i class="fa fa-plus"></i> New Article</button>
                            </div>
                        </div>
                        <div class="card-body " id="card-main">
                            <div class="table-responsive">
                                <table class="table table-hover" id="data-width" width="100%"
                                    style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th width="10%"></th>
                                            <th class="text-primary" width="20%">Judul</th>
                                            <th class="text-primary">Author</th>
                                            <th class="text-primary">Status</th>
                                            <th class="text-primary">Views</th>
                                            <th class="text-primary" width="25%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <div>
                                {{ env('APP_NAME') }} - {{ $title }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function setColor(isStatus) {
            switch (isStatus) {
                case 'published':
                    return 'primary';
                case 'archived':
                    return 'secondary';
                default:
                    return 'warning';
            }
        }

        function changeStatus(id, articleStat) {
            let url = "{{ route('account.article.changeStat', ['id' => '__ID__', 'status' => '__STATUS__']) }}";
            url = url.replace('__ID__', id).replace('__STATUS__', articleStat);
            window.location.href = url;
        }

        $(function() {
            let articleStat;
            table = $("#data-width").DataTable({
                searching: true,
                ajax: '{{ Request::url() }}/json',
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        className: "text-center",
                    },
                    {
                        data: "title",
                        className: "text-left text-truncate",
                    },
                    {
                        data: "author.name", // ⬅️ akses langsung ke properti relasi
                        name: "author.name",
                        className: "text-center",
                    },
                    {
                        data: "status",
                        className: "text-center",
                        render: function(data) {
                            articleStat = data;
                            return (
                                '<span class="' + data + '">' + data + '</span>'
                            );
                        },
                    },
                    {
                        data: "views",
                        className: "text-center"
                    },
                    {
                        data: "id",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return (
                                '<button type="button" class="btn btn-primary btn-detail" data-id="' +
                                data + '"><i class="fa fa-eye"></i> </button>\
                         <button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> </button>\
                          <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="data" href="delete/' +
                                data + '">\
                          <i class="fa fa-trash"></i> </a> \
        				  	      <form id="delete-form-' + data + '-data" action="{{ Request::url() }}/delete/' + data + '" method="GET" style="display: none;">\
                          </form>\
                         <button type="button" class="btn btn-warning btn-status" data-stat="archived" data-id="' + data + '" ' + cekStat(
                                    articleStat, "archived") + '>  <i class="fa fa-box-archive"></i> </button>\
                         <button type="button" class="btn btn-primary btn-status" data-stat="published" data-id="' + data + '" ' + cekStat(
                                    articleStat, "published") +
                                '>  <i class="fa fa-bullhorn"></i> </button>'
                            );
                        },
                    },
                ],
            });
        });

        $("body").on("click", ".btn-status", function() {
            var Id = jQuery(this).attr("data-id");
            var updatedStat = jQuery(this).attr("data-stat");
            event.preventDefault()
            Swal.fire({
                title: 'Update Article ?',
                text: "Article yang di update akan mempengaruhi situs !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Article Updated!',
                        '',
                        'success'
                    );
                    changeStatus(Id,updatedStat);
                }
            });
        })

        $("body").on("click", ".btn-add", function() {
            window.location.href = "{{ route('account.article.new') }}";
        })

        $("body").on("click", ".btn-category", function() {
            window.location.href = "{{ route('account.category') }}";
        })

        $("body").on("click", ".btn-tags", function() {
            window.location.href = "{{ route('account.tag') }}";
        })
    </script>
@endsection
