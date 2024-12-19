@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ asset('vendor/adminlte/dist/img/user4-128x128.jpg') }}"
                         alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">136 | Made Dhyo Pradnyadiva</h3>

                <p class="text-muted text-center">Mahasiswa</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>NIM</b> <a class="float-right">2105541136</a>
                    </li>
                    <li class="list-group-item">
                        <b>Kelas</b> <a class="float-right">Teknik Elektro 21</a>
                    </li>
                    <li class="list-group-item">
                        <b>Semester</b> <a class="float-right">7</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#details" data-toggle="tab">Detail Informasi</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="details">
                        <form class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="Made Dhyo Pradnyadiva" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" value="dhyo.pradnyadiva136@student.unud.ac.id" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Program Studi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="Teknik Elektro" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Angkatan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="2021" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="3" readonly>PERUMAHAN BEVERLY HILLS TEMBOK BIRU, USA</textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .profile-user-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }
    
    .form-control[readonly] {
        background-color: #f8f9fa;
        opacity: 1;
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Tambahkan JavaScript jika diperlukan
    });
</script>
@stop 