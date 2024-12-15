@section('titre', 'Importer un fichier client')
@extends('admin.fixe')

@section('body')
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">

            <!-- start page title -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">{{ config('app.name') }}</a>
                                </li>
                                <li class="breadcrumb-item active">Importer un fichier client</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->


            <div class="row">
                <div class="card radius-15 col-sm-6 mx-auto">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-title">
                                <h5 class="mb-0 my-auto">
                                    Importer un fichier client
                                </h5>
                            </div>
                        </div>
                        <div class="card-image">
                            <img src="/icons/6577ba52ca4c394d886459fe_excel.png" class="w-100" alt="" srcset="">
                        </div>
                        <br>
                        @livewire('Importation')
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('header')
    <style>
        body{
            background: url('/icons/cxcsd.webp')no-repeat !important;
            background-size: cover !important;
        }
        .card-image{
            overflow: hidden;
            border-radius: 10px;
        }
    </style>
@endsection
