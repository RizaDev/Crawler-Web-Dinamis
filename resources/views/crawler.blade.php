
@extends('layouts.main')

@section('container')
    <h1 class="mb-3 text-center">{{ $title }}</h1>
    <div class="d-flex justify-content-center align-items-center"">
        <div class="col-lg-8">
            <form action="" method="post">
                @csrf
                <div class="input-group mb-3">
                    <select class="form-select" id="choice_crawler" name="choice_crawler" >
                      <option selected>Pilih Web yang mau di crawler...</option>
                      <option value="1">Crawler Berita Mahkamah Agung</option>
                      <option value="2">Crawler Berita Pengadilan Agama</option>
                    </select>
                    <button class="btn btn-outline-secondary" type="submit" class="btn btn-primary">Crawler</button>
                  </div>
            </form>
        </div>
    </div>
@endsection