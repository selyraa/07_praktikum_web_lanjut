@extends('mahasiswas.layout')
 @section('content')
 <div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
        <div class="card-header">Detail Mahasiswa</div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>Nim: </b>{{$mahasiswas->nim}}</li>
                <li class="list-group-item"><b>Nama: </b>{{$mahasiswas->nama}}</li>
                <li class="list-group-item"><b>Kelas: </b>{{$mahasiswas->kelas->nama_kelas}}</li>
                <li class="list-group-item"><b>Jurusan: </b>{{$mahasiswas->jurusan}}</li>
                <li class="list-group-item"><b>No Handphone: </b>{{$mahasiswas->no_handphone}}</li>
                <li class="list-group-item"><b>Email: </b>{{$mahasiswas->email}}</li>
                <li class="list-group-item"><b>Tanggal Lahir: </b>{{$mahasiswas->tgl_lahir}}</li>
            </ul>
        </div>
        <a class="btn btn-success mt-3" href="{{ route('mahasiswas.index') }}">Kembali</a>
    </div>
</div>
</div>
@endsection