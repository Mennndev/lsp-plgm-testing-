@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<h4 class="mb-3">Edit Berita</h4>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.berita._form', ['berita' => $berita])
        </form>
    </div>
</div>
@endsection
