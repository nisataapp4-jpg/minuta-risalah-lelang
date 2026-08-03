@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">Edit Minuta Risalah Lelang</h3>

    <form action="{{ route('minuta.update',$minuta->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Tahun Risalah</label>
                <input
                    type="number"
                    name="tahun_risalah"
                    class="form-control"
                    value="{{ old('tahun_risalah',$minuta->tahun_risalah) }}"
                    required
                    min="1900"
                    max="2100">
            </div>

            <div class="form-group">
    <label>Lokasi Gudang</label>

    <select
        name="lokasi_gudang"
        class="form-control">

        <option value="">-- Pilih Gudang --</option>

        <option value="Gudang Lelang"
            {{ old('lokasi_gudang', $minuta->lokasi_gudang) == 'Gudang Lelang' ? 'selected' : '' }}>
            Gudang Lelang
        </option>

        <option value="Gudang Arsip Lelang"
            {{ old('lokasi_gudang', $minuta->lokasi_gudang) == 'Gudang Arsip Lelang' ? 'selected' : '' }}>
            Gudang Arsip Lelang
        </option>

        <option value="Gudang Rumah Dinas"
            {{ old('lokasi_gudang', $minuta->lokasi_gudang) == 'Gudang Rumah Dinas' ? 'selected' : '' }}>
            Gudang Rumah Dinas
        </option>

    </select>
</div>

<div class="form-group">
    <label>Lemari</label>

    <input
        type="text"
        name="lokasi_lemari"
        class="form-control"
        value="{{ old('lokasi_lemari', $minuta->lokasi_lemari) }}">
</div>

            <div class="col-md-6 mb-3">
                <label>Nomor Risalah</label>
                <input
                    type="text"
                    name="nomor_risalah"
                    class="form-control"
                    value="{{ old('nomor_risalah',$minuta->nomor_risalah) }}"
                    required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Tanggal Risalah</label>
                <input
                    type="date"
                    name="tanggal_risalah"
                    class="form-control"
                    value="{{ old('tanggal_risalah',$minuta->tanggal_risalah) }}"
                    required
                    oninput="batasiTahun(this)">
            </div>

            <div class="col-md-6 mb-3">
                <label>Pemohon Lelang</label>
                <input
                    type="text"
                    name="pemohon_lelang"
                    class="form-control"
                    value="{{ old('pemohon_lelang',$minuta->pemohon_lelang) }}"
                    required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Nama Debitur</label>
                <input
                    type="text"
                    name="nama_debitur"
                    class="form-control"
                    value="{{ old('nama_debitur',$minuta->nama_debitur) }}"
                    required>
            </div>

            <div class="form-group">
<label>Objek</label>
<textarea
name="objek"
class="form-control"
rows="6">{{ old('objek',$minuta->objek) }}</textarea>
</div>

            <div class="col-md-6 mb-3">
                <label>Jenis Lelang</label>
                <input
                    type="text"
                    name="jenis_lelang"
                    class="form-control"
                    value="{{ old('jenis_lelang',$minuta->jenis_lelang) }}"
                    >
            </div>

            <div class="col-md-6 mb-3">
                <label>Pejabat Lelang</label>
                <input
                    type="text"
                    name="pejabat_lelang"
                    class="form-control"
                    value="{{ old('pejabat_lelang',$minuta->pejabat_lelang) }}"
                    required>
            </div>

        </div>

        <button type="submit" class="btn btn-primary">
            Update
        </button>

        <a href="{{ route('minuta.index') }}" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

<script>
function batasiTahun(input) {

    let value = input.value;

    let bagian = value.split('-');

    if (bagian.length === 3) {

        bagian[0] = bagian[0].substring(0,4);

        input.value = bagian.join('-');

    }

}
</script>

@endsection