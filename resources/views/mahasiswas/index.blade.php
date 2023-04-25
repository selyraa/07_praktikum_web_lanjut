@extends('mahasiswas.layout')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
        </div>
    </div>
</div>
<form class="row mb-3 mt-5" action="{{ route('cari') }}" method="POST">
    @csrf
    <div class="col-md-5">
        <div class="d-flex flex-row">
            <input type="text" value="{{ (request()->cariMhs) ? request()->cariMhs : '' }}" name="cariMhs" class="form-control" placeholder="Cari Mahasiswa">
            <button type="submit" class="btn btn-primary ml-3">Cari</button>
        </div>
    </div>
    <div class="col-md-6 d-flex flex-row justify-content-end">
        <a class="btn btn-success" href="{{ route('mahasiswas.create') }}"> Input Mahasiswa</a>
    </div>
</form>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<table class="table table-bordered">
    <tr>
        <th>Nim</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Jurusan</th>
        <th>No Handphone</th>
        <th>Email</th>
        <th width="280px">Action</th>
    </tr>
    
    @foreach ($paginate as $mhs)
    <tr>
        <td>{{ $mhs->nim }}</td>
        <td>{{ $mhs->nama }}</td>
        <td>{{ $mhs->kelas->nama_kelas }}</td>
        <td>{{ $mhs->jurusan }}</td>
        <td>{{ $mhs->no_handphone }}</td>
        <td>{{ $mhs->email }}</td>
        <td>
            <form action="{{ route('mahasiswas.destroy',$mhs->nim) }}" method="POST">
                <a class="btn btn-info" href="{{ route('mahasiswas.show',$mhs->nim) }}">Show</a>
                <a class="btn btn-primary" href="{{ route('mahasiswas.edit',$mhs->nim) }}">Edit</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
<div class="col-md-12">
    {{ $paginate->links() }}
</div>
@endsection
