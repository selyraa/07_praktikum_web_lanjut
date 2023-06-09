<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use PDF;


class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        // $mahasiswas = Mahasiswa::all(); // Mengambil semua isi tabel
        // $posts = Mahasiswa::orderBy('nim', 'desc')->paginate(6);
        // return view('mahasiswas.index', compact('mahasiswas'));
        // with('i', (request()->input('page', 1) - 1) * 5);
        // $mahasiswas = Mahasiswa::paginate(5);
        // return view('mahasiswas.index', compact('mahasiswas'));

        //yang semula Mahasiswa::all, diubah menjadi with() yang menyatakan relasi
        $mahasiswas = Mahasiswa::with('kelas');
        $paginate = Mahasiswa::orderBy('nim', 'asc')->paginate(5);
        return view('mahasiswas.index', ['mahasiswas' => $mahasiswas, 'paginate' => $paginate]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswas.create', ['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->file('foto'));
        //melakukan validasi data
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'foto' => 'required|image|max:2048',
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_handphone' => 'required',
            'email' => 'required',
            'tgl_lahir' => 'required',
            ]);

            $imageName = time().'.'.$request->foto->extension();  
            $request->foto->move(public_path('storage'), $imageName);
            // $fileFoto = $request->file('foto');
            // $namaFoto = time() . '-' . $fileFoto->getClientOriginalName();
            // dd($namaFoto);
            // $fileFoto->storeAs('public/images', $namaFoto);

            $mahasiswa = new Mahasiswa;
            $mahasiswa->nim = $request->get('nim');
            $mahasiswa->nama = $request->get('nama');
            $mahasiswa->foto = $imageName;
            $mahasiswa->jurusan = $request->get('jurusan');
            $mahasiswa->no_handphone = $request->get('no_handphone');
            $mahasiswa->email = $request->get('email');
            $mahasiswa->tgl_lahir = $request->get('tgl_lahir');
            $mahasiswa->save();

            $kelas = new Kelas;
            $kelas->id = $request->get('kelas');

            //fungsi eloquent untuk menambah data dengan relasi belongsTo
            $mahasiswa->kelas()->associate($kelas);
            $mahasiswa->save();

            //jika data berhasil ditambahkan, akan kembali ke halaman utama
            return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa Berhasil Ditambahkan');
   
    }

    /**
     * Display the specified resource.
     */
    public function show($nim)
    {
    //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa

    $mahasiswas = Mahasiswa::with('kelas')->where('nim', $nim)->first();
    return view('mahasiswas.detail', ['mahasiswas' => $mahasiswas]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nim)
    {
       //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $nim)
    {
        // dd($request->file('foto'));

        
        //melakukan validasi data
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'foto' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'no_handphone' => 'required',
            'email' => 'required',
            'tgl_lahir' => 'required',
            ]);

            $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
            $mahasiswa->nim = $request->get('nim');
            $mahasiswa->nama = $request->get('nama');
            $mahasiswa->jurusan = $request->get('jurusan');
            $mahasiswa->no_handphone = $request->get('no_handphone');
            $mahasiswa->email = $request->get('email');
            $mahasiswa->tgl_lahir = $request->get('tgl_lahir');
            $mahasiswa->save();

            if($request->file('foto')){
                // hapus foto lama jika ada foto baru yang diupload
                if($mahasiswa->foto && file_exists(storage_path('app/public/'.$mahasiswa->foto))){
                    \Storage::delete('public/'.$mahasiswa->foto);
                }
                // simpan foto baru ke direktori penyimpanan
                $file = $request->file('foto');
                $nama_file = $file->getClientOriginalName();
                $file->storeAs('public/foto', $nama_file);
                // simpan nama file foto ke dalam kolom 'foto' pada tabel 'mahasiswas'
                $mahasiswa->foto = $nama_file;
            }              
            $image_name = $request->file('foto')->store('images', 'public');
            $mahasiswa->foto = $image_name;
           
            $kelas = new Kelas;
            $kelas->id = $request->get('kelas');

            $mahasiswa->kelas()->associate($kelas);
            $mahasiswa->save();

            return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($nim)->delete();
        return redirect()->route('mahasiswas.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');

    }
    public function cari(Request $request)
    {
        $cariMhs = $request->cariMhs;
        $paginate = Mahasiswa::where('nama', 'like', '%'.$cariMhs.'%')->paginate(5);
        return view('mahasiswas.index', compact('paginate'));
    }

    public function nilai($nim)
    {
        $mahasiswas = Mahasiswa::with('matakuliah')->where('nim', $nim)->first();
        $nilai = DB::table('mahasiswa_mata_kuliah')
                    ->join('matakuliah', 'matakuliah.id', '=', 'mahasiswa_mata_kuliah.mata_kuliah_id')
                    ->where('mahasiswa_mata_kuliah.mahasiswa_nim', $nim)
                    ->select('nilai')
                    ->get();

        return view('mahasiswas.nilai', ['mahasiswas' => $mahasiswas, 'nilai' => $nilai]);
    }

    public function exportPDF($nim)
    {
        $mahasiswas = Mahasiswa::with('matakuliah')->where('nim', $nim)->first();
        $nilai = DB::table('mahasiswa_mata_kuliah')
                    ->join('matakuliah', 'matakuliah.id', '=', 'mahasiswa_mata_kuliah.mata_kuliah_id')
                    ->where('mahasiswa_mata_kuliah.mahasiswa_nim', $nim)
                    ->select('nilai')
                    ->get();
        $pdf = PDF::loadView('mahasiswas.nilai_pdf', ['mahasiswas' => $mahasiswas, 'nilai' => $nilai]);
        return $pdf->download('KHS-' . $mahasiswas->nama . '.pdf');
        
    }

}

