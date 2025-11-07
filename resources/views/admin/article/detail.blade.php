@extends('layouts.backend.app')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="row">

            <div class="col-md-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$sub_title}}</h3>
                    </div>
                    <div class="card-body">
                        <form class="row"
                            action="{{ isset($post) ? route('account.article.update', $article->id) : route('account.article.store') }}"
                            method="POST" enctype="multipart/form-data">

                            @csrf
                            @if(isset($post))
                            @method('PUT')
                            @endif
                            <div class="col-lg-4">

                                {{-- TITLE --}}
                                <div class="form-group">
                                    <label for="title">Judul Artikel</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $post->title ?? '') }}"
                                        placeholder="Masukkan judul artikel..." onkeyup="generateSlug(this.value)">
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- SLUG --}}
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        id="slug" name="slug" value="{{ old('slug', $post->slug ?? '') }}" readonly>
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- IMAGE --}}
                                <div class="form-group">
                                    <label for="image">Gambar Utama</label>
                                    <input type="file" class="form-control-file @error('image') is-invalid @enderror"
                                        id="image" name="image">
                                    @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    @if(isset($post) && $post->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="Image Preview"
                                            class="img-thumbnail" width="200">
                                    </div>
                                    @endif
                                </div>

                                {{-- CATEGORY --}}
                                <div class="form-group">
                                    <label for="category_id">Kategori</label>
                                    <div class="input-group">
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id
                                                ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                data-toggle="modal" data-target="#addCategoryModal">+ Tambah</button>
                                        </div>
                                    </div>
                                    @error('category_id') <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- TAGS --}}
                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <select name="tags[]" id="tags" class="form-control" multiple>
                                        @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" @if(isset($post) && $post->
                                            tags->contains($tag->id)) selected @endif>
                                            {{ $tag->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- STATUS --}}
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status"
                                        name="status">
                                        <option value="draft" {{ old('status', $post->status ?? '') == 'draft' ?
                                            'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $post->status ?? '') == 'published' ?
                                            'selected' : '' }}>Published</option>
                                        <option value="archived" {{ old('status', $post->status ?? '') == 'archived' ?
                                            'selected' : '' }}>Archived</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- AUTHOR (opsional: hanya admin bisa ubah) --}}
                                @if(auth()->user()->role == 'Admin' ?? false)
                                <div class="form-group">
                                    <label for="author_id">Penulis</label>
                                    <select class="form-control @error('author_id') is-invalid @enderror" id="author_id"
                                        name="author_id">
                                        @foreach($authors as $author)
                                        <option value="{{ $author->id }}" {{ old('author_id', $post->author_id ??
                                            auth()->id()) == $author->id ? 'selected' : '' }}>
                                            {{ $author->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('author_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <input type="hidden" name="author_id" value="{{ auth()->id() }}">
                                @endif

                                {{-- VIEWS (readonly, auto) --}}
                                @if(isset($post))
                                <div class="form-group">
                                    <label for="views">Jumlah Dilihat</label>
                                    <input type="number" class="form-control" id="views" name="views"
                                        value="{{ $post->views }}" readonly>
                                </div>
                                @endif

                            </div>


                            <div class="col-lg-8">
                                {{-- CONTENT --}}
                                <div class="form-group">
                                    <label for="content">Konten</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" id="content"
                                        name="content" rows="6"
                                        placeholder="Tulis isi artikel di sini...">{{ old('content', $post->content ?? '') }}</textarea>
                                    @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="reset" class="btn btn-danger">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($post) ? 'Perbarui' : 'Simpan' }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        {{env('APP_NAME')}} - {{$title}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
{{-- Modal Tambah Kategori --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="addCategoryForm" method="POST" action="{{ route('categories.storeJson') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Kategori</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" name="slug" id="slug" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
@include('components.tinymceConfig')
@include('components.select2Config')
<script>
    function generateSlug(text) {
        const slug = text.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
        document.getElementById('slug').value = slug;
    }
</script>
<script>
// Preview upload gambar
document.getElementById('image').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        const preview = document.getElementById('preview-image');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>
<script>
    $('#addCategoryForm').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);

        $.post(form.attr('action'), form.serialize())
            .done(function (res) {
                $('#addCategoryModal').modal('hide');
                $('#category_id').append(
                    $('<option>', { value: res.id, text: res.name, selected: true })
                );
            })
            .fail(function () {
                alert('Gagal menambah kategori');
            });
    });
</script>
<script>
    $(document).ready(function () {
        $('#tags').select2({
            placeholder: 'Pilih tags...',
            allowClear: true,
            width: '100%',
        });
    });
</script>
@endsection