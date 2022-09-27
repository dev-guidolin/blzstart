@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h5>Planos Bot-Sinais</h5>
@stop

@section('content')
    <div class="row mt-5">
        <div class="col-sm-8 mx-auto">

            <div class="row">
                <div class="col-sm-4">
                    <div class="card shadow" >
                        <img src="{{ asset('images/mensal.png') }}"  class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ strtoupper($planos[0]->nome)     }}</h5>
                            <p class="card-text">APENAS {{moneyReal($planos[0]->valor)}}</p>
                            <p class="card-text">Valor mensal : R$ {{ moneyReal($planos[0]->valor / $planos[0]->validade) }}</p>
                            <a href="javascript:void(0)" class="btn btn-primary" data-id="{{ $planos[0]->id }}">Assinar</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card shadow" >
                        <img src="{{ asset('images/trimestral.png') }}"  class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ strtoupper($planos[1]->nome)     }}</h5>
                            <p class="card-text">APENAS {{moneyReal($planos[1]->valor)}}</p>
                            <p class="card-text">Valor mensal : R$ {{ moneyReal($planos[1]->valor / $planos[1]->validade) }}</p>
                            <a href="javascript:void(0)" class="btn btn-primary" data-id="{{ $planos[1]->id }}">Assinar</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card shadow" >
                        <img src="{{ asset('images/semestral.png') }}"  class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ strtoupper($planos[2]->nome)     }}</h5>
                            <p class="card-text">APENAS {{moneyReal($planos[2]->valor)}}</p>
                            <p class="card-text">Valor mensal : R$ {{ moneyReal($planos[2]->valor / $planos[2]->validade) }}</p>
                            <a href="javascript:void(0)" class="btn btn-primary" data-id="{{ $planos[2]->id }}">Assinar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        $(function (){
            $('.btn').click(function (){
                var planoId = $(this).data('id')
                console.log(planoId)

                $.ajax({
                    url: 'assinar-plano',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:{id: planoId},
                    type:"post",
                    method:"post",
                    success:(resp)=>{

                        if(resp.success){
                            window.location.href = resp.message
                        }else{
                            Swal.fire({
                                title: 'Ops!',
                                text:  resp.message,
                                icon: 'error',
                                confirmButtonText: 'Fechar'
                            })
                            return false
                        }

                    },
                    error:(err)=>{

                    }

                });

            })
        })
    </script>
@stop
