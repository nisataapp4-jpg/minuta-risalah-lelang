@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>

.dashboard-title{

    text-align:center;
    margin-bottom:40px;

}

.dashboard-title h2{

    font-size:30px;
    color:#003b71;
    font-weight:600;

}

/* Container Card */

.dashboard-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:25px;
    flex-wrap:wrap;
    margin-top:80px;
    margin-bottom:70px;
}

/* Card Dashboard */

.dashboard-card{

    width:360px;

    height:215px;

    border-radius:18px;

    display:flex;

    flex-direction:column;

    justify-content:center;

    align-items:center;

    color:#ffffff;

    box-shadow:0 12px 30px rgba(0,90,169,.20);

    transition:.3s;

}

.dashboard-card:hover{

    transform:translateY(-5px);

    box-shadow:0 12px 25px rgba(0,0,0,.18);

}

.card-total{

    background:linear-gradient(135deg,#005AA9,#0A74DA);

}

.card-petugas{

    background:linear-gradient(135deg,#198754,#2eb85c);

}

.card-pinjam{

    background:linear-gradient(135deg,#dc3545,#f04d5f);

}

/* Isi Card */

.dashboard-card h4{

    font-size:22px;

    font-weight:600;

    margin-bottom:16px;

}

.dashboard-card h1{

    font-size:58px;

    font-weight:700;

    margin:0;

}

.dashboard-filter-wrapper{

    display:flex;

    justify-content:flex-start;

    align-items:center;

    margin-top:20px;

    margin-bottom:35px;

}

.dashboard-filter{

    width:210px;

    height:60px;

    padding:0 22px;

    border-radius:16px;

    border:2px solid #005AA9;

    background:#EEF5FF;

    color:#005AA9;

    font-size:18px;

    font-weight:600;

    cursor:pointer;

    transition:.25s;

    appearance:none;

}

.dashboard-filter:hover{

    background:#DCEBFF;

    border-color:#004B8D;

}

.dashboard-filter:focus{

    outline:none;

    border-color:#003B71;

    box-shadow:0 0 12px rgba(0,90,169,.25);

}

@media(max-width:900px){

.dashboard-wrapper{

    display:flex;

    justify-content:center;

    align-items:center;

    gap:35px;

}

.dashboard-card{

    width:100%;
    max-width:420px;

}
}

</style>


<div class="dashboard-filter-wrapper">

    <form method="GET" action="{{ route('dashboard') }}">

        <select
            name="tahun"
            class="dashboard-filter"
            onchange="this.form.submit()">

            <option value="semua">
                Semua Tahun
            </option>

            @foreach($tahunList as $item)

                <option
                    value="{{ $item }}"
                    {{ $tahun == $item ? 'selected' : '' }}>

                    {{ $item }}

                </option>

            @endforeach

        </select>

    </form>

</div>

<div class="dashboard-wrapper">

    <div class="dashboard-card card-total">

        <h4>Minuta KPKNL</h4>

        <h1>{{ $minutaKPKNL }}</h1>

    </div>

    <div class="dashboard-card card-petugas">

        <h4>Minuta di Petugas</h4>

        <h1>{{ $minutaDiPetugas }}</h1>

    </div>

    <div class="dashboard-card card-pinjam">

        <h4>Minuta Dipinjam</h4>

        <h1>{{ $minutaDipinjam }}</h1>

    </div>

</div>

@endsection