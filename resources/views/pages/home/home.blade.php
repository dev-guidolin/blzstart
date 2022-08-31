<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"  />
    <link href="{{ mix('pages/home/css/app.css') }}" rel="stylesheet">
    <title>Document</title>

    <style>
        html,body{
            height: 100%;
        }
        .hero{
            /*background-image: url(./pages/home/images/blaze.png);*/
            background-image: url(https://images.unsplash.com/photo-1501721731301-5aaa8228b935?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2670&q=80);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 50% 50%;
        }
        .hero-bk{
            background: #0f1923;
        }
        .destak{
            color: #f12c4c
        }
        .destak-green{
            color: #59CE8F
        }
        .btn-color{
            background: #f12c4c;
            color: white;
            padding: 10px   ;
            outline: none!important;
            border-radius: 8px;
            transition-duration: 0.4s;
            font-size: 28px;
        }
        .btn-color:hover{
            background: #de2e49 !important;
            color: white;
        }
        .btn-green{
            background: #59CE8F;
            color: white;
            padding: 10px   ;
            outline: none!important;
            border-radius: 8px;
            transition-duration: 0.4s;
            font-size: 28px;
        }
        .btn-green:hover{
            background: #4aab79 !important;
            color: white;
        }
        .bg-red{
            background: #f12c4c;
            color: white
        }
        .border-red{
            border: 1px solid #f12c4c;
        }
        .bg-green{
            background: #59CE8F;;
            color: white
        }
        .border-green{
            border: 1px solid #59CE8F;;
        }
        .text-green{
            color: #59CE8F;
        }
        .text-red{
            color: #f12c4c;
        }
    </style>
</head>
<body>

<div class="container-fluid hero-bk">
    <div class="container col-xl-10 col-xxl-8 px-4 py-5 ">
        <div class="row align-items-center g-lg-5 py-5 ">
            <div class="col-lg-7 text-center text-lg-start" >
                <h1 class="display-4 fw-bold lh-1 mb-3 text-center destak" >
                   CRIE GRUPOS DE SINAIS NO TELEGRAM <b class="destak-green">ILIMITADOS!</b>
                </h1>
                <p class="col-lg-10 fs-4 text-white">
                    Crie grupos e envie sinais para seus assinantes sem limite de mensagens e nem limite de grupos!

                    <i class="fa-solid fa-arrow-right text-white"></i>

                </p>
                <h4 class="destak-green text-center">COMECE A FATURAR COM SUAS TÁTICAS AGORA</h4>
                <div class="d-grid gap-2">
                    <button class="btn-color planos" type="button" title="Enviei seus palpites para grupos no Telegram e ganhe dinheiro com isso.">Assinar Plano </button>
                </div>
            </div>
            <div class="col-md-10 mx-auto col-lg-5">
                <img class="img-fluid " src="./pages/home/images/blaze/blazer1.png" alt="">
            </div>
        </div>
    </div>
</div>
<section>
    <div class="container px-4 py-5" id="hanging-icons">
        <h2 class="pb-2 border-bottom">Você está deixando de ganhar muito dinheiro!</h2>
        <p>
            Hoje há uma buscar enorme por jogos online e muita gente disposta a <b>PAGAR</b> por bons palpites.
        </p>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            <div class="col d-flex align-items-start">
                <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <svg class="bi" width="1em" height="1em"><use xlink:href="#toggles2"></use></svg>
                </div>
                <div>
                    <h2>Grupos Ilimitados</h2>
                    <p>
                        Você pode criar quantos grupos quiser para enviar seus sinais e cada palpite pode ser enviados para um ou todos os seus grupos cadastrados.
                    </p>
                    <a href="#" class="btn btn-primary planos">
                        Assinar plano
                    </a>
                </div>
            </div>
            <div class="col d-flex align-items-start">
                <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <svg class="bi" width="1em" height="1em"><use xlink:href="#cpu-fill"></use></svg>
                </div>
                <div>
                    <h2>Métricas de Acertos</h2>
                    <p>
                        Nossas métricas irá lhe ajudar a montar suas estratégicas, nosso algoritmo irá auxiliar para que seus membros tenham o maior número de acertos.
                    </p>
                    <a href="#" class="btn btn-primary planos">
                        Assinar plano
                    </a>
                </div>
            </div>
            <div class="col d-flex align-items-start">
                <div class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <svg class="bi" width="1em" height="1em"><use xlink:href="#tools"></use></svg>
                </div>
                <div>
                    <h2>Membros Ilimitados</h2>
                    <p>
                        Sim, isso mesmo, você pode ter quantos membros quiser e <b style="text-transform: uppercase">se assinar agora</b>, não irá pagar mais nada por isso. Para sempre.
                    </p>
                    <a href="#" class="btn btn-primary planos">
                        Primary button
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container" id="planos">
        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 fw-normal">OS PLANOS MAIS BARATOS DA INTERNET</h1>
            <h3 class="text-red text-center">SEM TAXA DE ADESÃO!</h3>
            <p class="fs-5 text-muted">

            </p>
        </div>

        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm ">
                    <div class="card-header py-3 bg-green border-green">
                        <h4 class="my-0 fw-normal">Mensal</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">R$ 49,90<small class="text-muted fw-light">/mês</small></h1>
                        <ul class="list-unstyled  mt-3 mb-4" style="text-align: left!important;">
                            <li><i class="fa fa-check text-green"></i> Crie Robôes para Blaze  Double </li>
                            <li><i class="fa-solid fa-x text-red"></i> Crie Robôes para Blaze Crash  ( em breve )</li>
                            <li><i class="fa fa-check text-green"></i> Métricas diárias</li>
                            <li><i class="fa fa-check text-green"></i> Gráficos avançados</li>
                            <li><i class="fa fa-check text-green"></i> Crie vários canal/grupo com sua marca (100% White Label)</li>
                            <li><i class="fa fa-check text-green"></i> Alertas todos os dias, sem limites</li>
                            <li><i class="fa fa-check text-green"></i> Acesso imediato</li>
                            <li><i class="fa fa-check text-green"></i> Suporte rápido e personalizado</li>
                        </ul>
                        <button type="button" class="w-100 btn btn-lg btn-outline-primary contratar">CONTRATAR</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm ">
                    <div class="card-header py-3 bg-dark text-white">
                        <h4 class="my-0 fw-normal">Trimestral</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">R$ 44,90<small class="text-muted fw-light">/mês</small></h1>
                        <ul class="list-unstyled  mt-3 mb-4" style="text-align: left!important;">
                            <li><i class="fa fa-check text-green"></i> Crie Robôes para Blaze  Double </li>
                            <li><i class="fa fa-check text-green"></i> Crie Robôes para Blaze Crash  ( em breve )</li>
                            <li><i class="fa fa-check text-green"></i> Métricas diárias</li>
                            <li><i class="fa fa-check text-green"></i> Gráficos avançados</li>
                            <li><i class="fa fa-check text-green"></i> Crie vários canal/grupo com sua marca (100% White Label)</li>
                            <li><i class="fa fa-check text-green"></i> Alertas todos os dias, sem limites</li>
                            <li><i class="fa fa-check text-green"></i> Acesso imediato</li>
                            <li><i class="fa fa-check text-green"></i> Suporte rápido e personalizado</li>
                        </ul>
                        <button type="button" class="w-100 btn btn-lg btn-primary">CONTRATAR</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm border-red">
                    <div class="card-header py-3 bg-red border-red">
                        <h4 class="my-0 fw-normal">Semestral</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">R$ 39,90<small class="text-muted fw-light">/mês</small></h1>
                        <ul class="list-unstyled  mt-3 mb-4" style="text-align: left!important;">
                            <li><i class="fa fa-check text-green"></i> Crie Robôes para Blaze  Double </li>
                            <li><i class="fa fa-check text-green"></i> Crie Robôes para Blaze Crash  ( em breve )</li>
                            <li><i class="fa fa-check text-green"></i> Métricas diárias</li>
                            <li><i class="fa fa-check text-green"></i> Gráficos avançados</li>
                            <li><i class="fa fa-check text-green"></i> Crie vários canal/grupo com sua marca (100% White Label)</li>
                            <li><i class="fa fa-check text-green"></i> Alertas todos os dias, sem limites</li>
                            <li><i class="fa fa-check text-green"></i> Acesso imediato</li>
                            <li><i class="fa fa-check text-green"></i> Suporte rápido e personalizado</li>
                        </ul>
                        <button type="button" class="w-100 btn btn-lg btn-primary">CONTRATAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ mix('pages/home/js/app.js') }}"></script>
<script>
$(function (){
    $('.planos').click(function (){
        $('html, body').animate({
            scrollTop: $("#planos").offset().top,
        }, 1000)
    })
    $(".contratar").click(function (){
        window.location.href = "{{ route('register') }}"
    })
})
</script>
</body>
</html>
