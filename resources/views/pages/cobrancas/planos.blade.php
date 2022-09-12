@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h5>Planos Bot-Sinais</h5>
@stop

@section('content')
    <div class="row mt-5">
        <div class="col-sm-8 mx-auto">

            <div class="row">
                @foreach($planos as $plano)
                    <div class="col-sm-4">
                        <div class="card shadow" >
                            <img src="https://images.unsplash.com/photo-1506784365847-bbad939e9335?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1468&q=80"  class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ strtoupper($plano->nome)     }}</h5>
                                <p class="card-text">APENAS {{moneyReal($plano->valor)}}</p>
                                <p class="card-text">Valor mensal : R$ {{ moneyReal($plano->valor / $plano->validade) }}</p>
                                <a href="javascript:void()" class="btn btn-primary" data-id="{{ $plano->id }}">Assinar</a>
                            </div>
                        </div>
                    </div>
                @endforeach
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
