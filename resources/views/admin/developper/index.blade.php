@section('titre', 'Espace développeur')
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
                                <li class="breadcrumb-item active">Espace développeur</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->


            <div class="card radius-15">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-title">
                            <h5 class="mb-0 my-auto">
                                Espace développeur
                            </h5>
                        </div>
                        <div>
                            <div class="input-group">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#add">
                                <i class="ri-pages-line"></i>
                                Ajouter un domaine
                            </button>
                            <a href="{{ route('add-template') }}">
                                <button class="btn btn-dark btn-sm" type="button">
                                    <i class="ri-pages-line"></i>
                                    Ajouter un template
                                </button>
                            </a>
                            </div>
                        </div>
                    </div>
                    <hr />
                    @include('components.alert')

                    @livewire('Developper.ListTemplate')

                </div>
            </div>
        </div>
    </div>



    <!-- Center modal content -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myCenterModalLabel">
                        Gestion des nom de domaines.
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @livewire('Developper.GestionDomaine')
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


@endsection

@section('header')
    <style>
        body{
            background: url('/icons/cxcsd.webp')no-repeat !important;
            background-size: cover !important;
        }
    </style>
@endsection
