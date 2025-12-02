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
                                <button class="btn btn-primary btn-add"><i class="fa fa-plus"></i> New User</button>
                            </div>
                        </div>
                        <div class="card-body " id="card-main">
                            <div class="table-responsive">
                                <table class="table table-hover" id="data-width" width="100%"
                                    style="table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th width="7%"></th>
                                            <th class="text-primary" width="10%">Avatar</th>
                                            <th class="text-primary" width="20%">Nama</th>
                                            <th class="text-primary">Email</th>
                                            <th class="text-primary">Hak Akses</th>
                                            <th class="text-primary" width="15%">Action</th>
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
                        data: "avatar",
                        className: "text-center",
                        render: function(data){
                            return (
                                '<img class="rounded-circle mr-2" src="'+data+'" width="25" height="25" alt="">'
                            )
                        }
                    },
                    {
                        data: "name",
                        className: "text-center",
                    },
                    {
                        data: "email",
                        name: "email",
                        className: "text-center",
                    },
                    {
                        data: "role",
                        className: "text-center",
                        render: function(data) {
                            return (
                                '<span class="' + data + '">' + data + '</span>'
                            );
                        },
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
                              <a class="btn btn-danger btn-hapus" data-id="' + data +
                                '" data-handler="data" href="delete/' +
                                data + '">\
                              <i class="fa fa-trash"></i> </a> \
            				  	      <form id="delete-form-' + data + '-data" action="{{ Request::url() }}/delete/' + data + '" method="GET" style="display: none;">\
                              </form>'
                            );
                        },
                    },
                ],
            });
        });

        $("body").on("click", ".btn-add", function() {
            window.location.href = "{{ route('account.user.new') }}";
        })

        $("body").on("click", ".btn-edit", function() {
            var Id = jQuery(this).attr("data-id");
            let url = "{{ route('account.user.edit', ['user' => '__ID__']) }}";
            url = url.replace('__ID__', Id);
            window.location.href = url;
        })
    </script>
@endsection
