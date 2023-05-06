@extends('articles.layout')
@section('content')
<!DOCTYPE html>
<html>
    <head>
        <title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
    </head>
    <body>
        <style type="text/css">
            table tr td,
            table tr th{
                font-size: 9pt;
            }
        </style>
        <center>
            <h5>Laporan Artikel</h4>
        </center>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$a->title}}</td>
                    <td>{{$a->content}}</td>
                    <!-- <td><img src="{{ asset($a->featured_image) }}" alt="featured_image"> </td> -->
                    <td>
                    <?php
                    $foto = storage_path('public/storage/images/image.jpg');
                    if ($a->featured_image!=null) $foto = storage_path('public/storage/images/' .$a->featured_image);
                    ?>
                    <img src="{{ $foto }}">
                    </td>
                    <!-- <td>{{$a->featured_image}}</td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
@endsection