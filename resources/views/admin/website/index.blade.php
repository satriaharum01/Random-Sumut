@extends('layouts.backend.app')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row justify-content-between">

                <div class="col-md-8 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $sub_title }}</h3>
                            <div class="card-options align-items-center d-flex">
                                <button class="btn btn-primary btn-add me-3 mx-2"> 
                                    New
                                </button>
                                <button class="btn btn-primary btn-add mx-2" id="btnRefresh">  
                                    <i class="fa fa-sync"></i> Refresh Data
                                </button>
                            </div>

                        </div>
                        <div class="card-body " id="card-main">
                            <div class="table-responsive ">
                                <table class="table table-hover" id="data-width" width="100%">
                                    <thead>
                                        <tr> 
                                            <th class="text-primary" width="20%">Social Media</th>
                                            <th class="text-primary">URL</th> 
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
                            <h3 class="card-title title-sub">Tambah Social Media</h3>
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
        let table;

        $(function() { 
            loadData();
            bindEvents();
        });

        function generateSlug(text) {
            const slug = text.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
            document.getElementById('slug').value = slug;
        }

        function loadData() {
            table = $("#data-width").DataTable({
                searching: true,
                ajax: {
                    url: "{{ route('account.website.json') }}",
                    beforeSend: function () {
                        showLoading();
                    }
                },
                columns: [
                    {
                        data: "key",
                        className: "text-center",
                    },
                    {
                        data: "value",
                        name: "Value",
                        className: "text-center",
                    },
                    {
                        data: "id",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            return `
                                <button type="button" class="btn btn-success btn-edit" data-id="${data}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <a class="btn btn-danger btn-hapus" data-id="${data}" href="delete/${data}">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <form id="delete-form-${data}-data"
                                    action="{{ Request::url() }}/delete/${data}"
                                    method="POST"
                                    style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            `;
                        }
                    }
                ]
            });
        }

        function showLoading(){
            $("#loading").show();
            $("#dataContainer").html(`
                <tr>
                    <td colspan="4" class="text-center">
                        <i class="fa fa-spinner fa-spin"></i> Loading data...
                    </td>
                </tr>
            `);
        }

        function bindEvents(){
            $("#btnRefresh").on("click", function(){
                table.ajax.reload(null, false);
                const $btn = $(this);
                const originalHtml = $btn.html();

                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Refreshing...');

                setTimeout(function() {
                    $btn.prop('disabled', false).html(originalHtml);
                }, 1500);
            });
        }
    </script>
@endsection
