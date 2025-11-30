@extends('layouts.backend.app')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row justify-content-between">

                <div class="col-md-8 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $sub_title }}</h3>
                            <div class="card-options align-items-center">
                                <button class="btn btn-primary btn-add"><i class="fa fa-plus"></i> New</button>
                            </div>
                        </div>
                        <div class="card-body " id="card-main">
                            <div class="table-responsive ">
                                <table class="table table-hover" id="data-width" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="10%"></th>
                                            <th class="text-primary" width="20%">Category</th>
                                            <th class="text-primary">Slug</th>
                                            <th class="text-primary">Jumlah Article</th>
                                            <th class="text-primary">Action</th>
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
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title title-sub">Tambah Tags</h3>
                        </div>
                        <form action="{{ Request::url() }}/store" method="POST" id="compose-form">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @csrf
                                <div class="col-lg-12">
                                    {{-- NAME --}}
                                    <div class="form-group">
                                        <label for="name">Tags</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Tags Baru..."
                                            onkeyup="generateSlug(this.value)">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- SLUG --}}
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="slug" name="slug" readonly>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="reset" class="btn btn-danger btn-reset mr-2 d-none">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($post) ? 'Perbarui' : 'Simpan' }}
                                </button>
                            </div>
                        </form>
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

        $(function() {
            table = $("#data-width").DataTable({
                searching: true,
                ajax: '{{ Request::url() }}/json',
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        className: "text-center",
                    },
                    {
                        data: "name",
                        className: "text-center",
                    },
                    {
                        data: "slug", // ⬅️ akses langsung ke properti relasi
                        name: "slug",
                        className: "text-center",
                    },
                    {
                        data: "articles_count",
                        className: "text-center",
                    },
                    {
                        data: "id",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return (
                                '<button type="button" class="btn btn-success btn-edit" data-id="' +
                                data + '"><i class="fa fa-edit"></i> </button>\
                                  <a class="btn btn-danger btn-hapus" data-id="' + data +
                                '" data-handler="data" href="delete/' +
                                data + '">\
                                  <i class="fa fa-trash"></i> </a> \
                				  	      <form id="delete-form-' + data + '-data" action="{{ Request::url() }}/delete/' + data + '" method="POST" style="display: none;">\
                                  @csrf @method('DELETE')\
                                  </form>'
                            );
                        },
                    },
                ],
            });
        });

        function generateSlug(text) {
            const slug = text.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
            document.getElementById('slug').value = slug;
        }
    </script>
    <script>
        function kosongkan() {
            jQuery("#compose-form input[name=name]").val("");
            jQuery("#compose-form input[name=slug]").val("");
            $("#compose-form .btn-reset").addClass('d-none');
            jQuery(".title-sub").html("Tambah Tags");

            setFormMethod('compose-form', 'POST');
        }

        function set_value(value) {
            jQuery("#compose-form input[name=name]").val(value.name);
            jQuery("#compose-form input[name=slug]").val(value.slug);
            jQuery("#compose-form .btn-reset").removeClass('d-none');
        }

        $("body").on("click", ".btn-add", function() {
            kosongkan();

            jQuery("#compose-form").attr("action", '{{ Request::url() }}/store/');
        });

        $("body").on("click", ".btn-edit", function() {
            var Id = jQuery(this).attr("data-id");
            setFormMethod('compose-form', 'PUT');
            find_data(Id);

            jQuery("#compose-form").attr("action", '{{ Request::url() }}/update/' + Id);
            jQuery(".title-sub").html("Update Tags");
        });
    </script>
@endsection
