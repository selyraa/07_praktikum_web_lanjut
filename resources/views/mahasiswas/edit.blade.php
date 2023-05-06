@extends('mahasiswas.layout')
 @section('content')
 <div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
        <div class="card-header">Edit Mahasiswa</div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="post" action="{{ route('mahasiswas.update', $mahasiswa->nim) }}" id="myForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nim">Nim</label> 
                    <input type="text" name="nim" class="form-control" id="nim" value="{{ $mahasiswa->nim }}" aria-describedby="nim" > 
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label> 
                    <input type="text" name="nama" class="form-control" id="nama" value="{{ $mahasiswa->nama }}" aria-describedby="nama" > 
                </div>
                <div class="form-group">
                    <label for="foto">Foto Mahasiswa</label>
                    <input type="file" class="form-control" required="required" name="foto"></br>
                    <img width="100px" height="100px" src="{{asset('storage/'.$mahasiswa->foto)}}">
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select name="kelas" class="form-control">
                        @foreach($kelas as $kls)
                            <option value="{{$kls->id}}" {{ $mahasiswa->kelas_id == $kls->id ? 'selected' : '' }}>{{$kls->nama_kelas}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label> 
                    <input type="text" name="jurusan" class="form-control" id="jurusan" value="{{ $mahasiswa->jurusan }}" aria-describedby="jurusan" > 
                </div>
                <div class="form-group">
                    <label for="no_handphone">No Handphone</label> 
                    <input type="text" name="no_handphone" class="form-control" id="no_handphone" value="{{ $mahasiswa->no_handphone }}" aria-describedby="no_handphone" > 
                </div>
                <div class="form-group">
                    <label for="email">Email</label> 
                    <input type="text" name="email" class="form-control" id="email" value="{{ $mahasiswa->email }}" aria-describedby="email" > 
                </div>
                <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label> 
                    <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" value="{{ $mahasiswa->tgl_lahir }}" aria-describedby="tgl_lahir" > 
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</div>
@endsection