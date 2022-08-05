@if(Request::is('eventos/musica'))
<style>
    .btneventos:after{
        background: #f79e00 !important;
    }
</style>
@endif

@if(Request::is('eventos/desporto'))
<style>
    .btneventos:after{
        background: #2A7221 !important;
    }
</style>
@endif

@if(Request::is('eventos/teatro'))
<style>
    .btneventos:after{
        background: #508AA8 !important;
    }
</style>
@endif

@if(Request::is('eventos/arte'))
<style>
    .btneventos:after{
        background: #B73A33 !important;
    }
</style>
@endif
<!-- Seccao Musica -->
<section>
    @if (Request::is('eventos/musica') || Request::is('eventos/arte'))
        <div class="blog animate-top" align="center">
    @else 
        <div class="blog animate-bottom" align="center">    
    @endif   
    
        <div class="container">
            @if(Request::is('eventos/musica'))
                <h1 class="topicomusica">Musica</h1>
            @endif
            @if(Request::is('eventos/teatro'))
                <h1 class="topicoteatro">Teatro</h1>
            @endif
            @if(Request::is('eventos/arte'))
                <h1 class="topicoarte">Arte</h1>
            @endif
            @if(Request::is('eventos/desporto'))
                <h1 class="topicodesporto">Desporto</h1>
            @endif
            
            <div class="owl-carousel owl-theme blog-post">
                <?php $i = 0; ?>
                
                @if (count($eventos)==0)
                    
                    <div class="blog-content" data-aos="fade-right" data-aos-delay="200">
                        <img src="{{ asset("storage/imagens_eventos/vazioarte.svg") }}" alt="post-1">
                        <div class="blog-title">
                            <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                        <h1>Sem evento</h1>
                                    </div>
                            
                            <button class="btneventos" onclick="window.location.href='#'" ><span>Vazio</span></button>
                            
                            <br/>
                        </div>
                    </div>
                    <div class="blog-content" data-aos="fade-in" data-aos-delay="200">
                        <img src="{{ asset("storage/imagens_eventos/vazioarte.svg") }}" alt="post-1">
                        <div class="blog-title">
                            <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                        <h1>Sem evento</h1>
                                    </div>
                            <button class="btneventos" onclick="window.location.href='#'" ><span>Vazio</span></button>
                            
                            <br/>
                        </div>
                    </div>
                    <div class="blog-content" data-aos="fade-left" data-aos-delay="200">
                        <img src="{{ asset("storage/imagens_eventos/vazioarte.svg") }}" alt="post-1">
                        <div class="blog-title">
                            <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                        <h1>Sem evento</h1>
                                    </div>
                            <button class="btneventos" onclick="window.location.href='#'" ><span>Vazio</span></button>
                            
                            <br/>
                        </div>
                    </div>
                    <div class="blog-content" data-aos="fade-right" data-aos-delay="200">
                        <img src="{{ asset("storage/imagens_eventos/vazioarte.svg") }}" alt="post-1">
                        <div class="blog-title">
                            <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                        <h1>Sem evento</h1>
                                    </div>
                            <button class="btneventos" onclick="window.location.href='#'" ><span>Vazio</span></button>
                            
                            <br/>
                        </div>
                    </div>
                @endif
                

                @if (count($eventos)==1)
                    @foreach ($eventos as $evento)
                            
                            <?php $i++; ?>
                            @php
                                                $datetime = new DateTime();
                                                $timezone = new DateTimeZone('Europe/Lisbon');
                                                $datetime->setTimezone($timezone);

                                                $horaatual =  $datetime->format('H:i:s');

                                                if(strtotime($evento->horafim) == strtotime("00:00:00")){
                                    $horafimevento = "23:59:00";
                                }else{
                                    $horafimevento = $evento->horafim;
                                }

                                            @endphp
                            
                            <?php if($i==1){ ?>
                                <div class="blog-content" data-aos="fade-right" data-aos-delay="200">
                                    <img src="{{ asset("storage/imagens_eventos/$evento->foto") }}" alt="post-1">
                                    <div class="blog-title">
                                        <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                            <h1>{{ $evento->evento }}</h1>
                                        </div>
                                        <button class="btneventos" onclick="window.location.href='{{ URL('eventos/detalhes', [$evento->idevento]) }}'" ><span>Detalhes</span></button>
                                        &nbsp;
                                        @if ($evento->estadoeventoid==1 && !(strtotime(date('Y-m-d')) > strtotime($evento->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                        @if ($evento->tpeventolugarid==2)
                                            <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" ><span>Comprar</span></button>
                                        
                                        @else
                                            <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};' ><span>Comprar</span></button>     
                                        @endif
                                    @endif
                                    @if (($evento->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($evento->datafim)) || (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                        @if ($evento->tpeventolugarid==2)
                                            <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" style="cursor: not-allowed;" ><span>Comprar</span></button>
                                        
                                        @else
                                            <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};'  style="cursor: not-allowed;" ><span>Comprar</span></button>     
                                        @endif
                                    @endif

                                        <div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                            @if ($evento->estadoeventoid == 1)
                                                @if (strtotime(date('Y-m-d')) > strtotime($evento->datafim))
                                                    
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento))
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                

                                                @if (strtotime(date('Y-m-d')) >=  strtotime($evento->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($evento->datafim) && strtotime($evento->datainicio) != strtotime($evento->datafim))
                                                
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                @endif

                                                @if (strtotime($horaatual) < strtotime($evento->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio))
                                                <div class="rainbow-breve" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    
                                                </div> 
                                                @endif

                                                @if ( (strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $evento->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($evento->datainicio)))
                                                
                                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                        
                                                    </div> 
                                                @endif
                                            @else 
                                                <div class="rainbow-cancelado" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Cancelado!</p>
                                                    
                                                </div> 
                                            @endif
                                            
                                            
                                        </div>
                                        
                                        <br/>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="blog-content" data-aos="fade-in" data-aos-delay="200">
                                <img src="{{ asset("storage/imagens_eventos/vazioarte.svg") }}" alt="post-1">
                                <div class="blog-title">
                                    <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                        <h1>Sem evento</h1>
                                    </div>
                                    <button class="btneventos" onclick="window.location.href='#'" ><span>Vazio</span></button>
                                    
                                    <br/>
                                </div>
                            </div>
                            <div class="blog-content" data-aos="fade-left" data-aos-delay="200">
                                <img src="{{ asset("storage/imagens_eventos/vazioarte.svg") }}" alt="post-1">
                                <div class="blog-title">
                                    <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                        <h1>Sem evento</h1>
                                    </div>
                                    <button class="btneventos" onclick="window.location.href='#'" ><span>Vazio</span></button>
                                    
                                    <br/>
                                </div>
                            </div>
                            <div class="blog-content" data-aos="fade-right" data-aos-delay="200">
                                <img src="{{ asset("storage/imagens_eventos/vazioarte.svg") }}" alt="post-1">
                                <div class="blog-title">
                                    <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                        <h1>Sem evento</h1>
                                    </div>
                                    <button class="btneventos" onclick="window.location.href='#'" ><span>Vazio</span></button>
                                    
                                    <br/>
                                </div>
                            </div>
                            
                    @endforeach                           
                @endif

                @if (count($eventos)==2)
                    @foreach ($eventos as $evento)
                            
                            <?php $i++; ?>
                            @php
                                                $datetime = new DateTime();
                                                $timezone = new DateTimeZone('Europe/Lisbon');
                                                $datetime->setTimezone($timezone);

                                                $horaatual =  $datetime->format('H:i:s');

                                                if(strtotime($evento->horafim) == strtotime("00:00:00")){
                                    $horafimevento = "23:59:00";
                                }else{
                                    $horafimevento = $evento->horafim;
                                }

                                            @endphp
                            <?php if($i==1){ ?>
                                <div class="blog-content" data-aos="fade-right" data-aos-delay="200">
                                    <img src="{{ asset("storage/imagens_eventos/$evento->foto") }}" alt="post-1">
                                    <div class="blog-title">
                                        <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                            <h1>{{ $evento->evento }}</h1>
                                        </div>
                                        
                                        <button class="btneventos" onclick="window.location.href='{{ URL('eventos/detalhes', [$evento->idevento]) }}'" ><span>Detalhes</span></button>
                                        &nbsp;
                                        @if ($evento->estadoeventoid==1 && !(strtotime(date('Y-m-d')) > strtotime($evento->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};' ><span>Comprar</span></button>     
                                            @endif
                                        @endif
                                        @if (($evento->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($evento->datafim)) || (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" style="cursor: not-allowed;" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};'  style="cursor: not-allowed;" ><span>Comprar</span></button>     
                                            @endif
                                        @endif

                                        <div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                            @if ($evento->estadoeventoid == 1)
                                                @if (strtotime(date('Y-m-d')) > strtotime($evento->datafim))
                                                    
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento))
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                

                                                @if (strtotime(date('Y-m-d')) >=  strtotime($evento->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($evento->datafim) && strtotime($evento->datainicio) != strtotime($evento->datafim))
                                                
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                @endif

                                                @if (strtotime($horaatual) < strtotime($evento->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio))
                                                <div class="rainbow-breve" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    
                                                </div> 
                                                @endif

                                                @if ( (strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $evento->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($evento->datainicio)))
                                                
                                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                        
                                                    </div> 
                                                @endif
                                            @else 
                                                <div class="rainbow-cancelado" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Cancelado!</p>
                                                    
                                                </div> 
                                            @endif
                                            
                                            
                                        </div>
                                        
                                        <br/>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($i==2){ ?>
                                <div class="blog-content" data-aos="fade-in" data-aos-delay="200">
                                    <img src="{{ asset("storage/imagens_eventos/$evento->foto") }}" alt="post-1">
                                    <div class="blog-title">
                                        <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                            <h1>{{ $evento->evento }}</h1>
                                        </div>
                                        <button class="btneventos" onclick="window.location.href='{{ URL('eventos/detalhes', [$evento->idevento]) }}'" ><span>Detalhes</span></button>
                                        &nbsp;
                                        @if ($evento->estadoeventoid==1 && !(strtotime(date('Y-m-d')) > strtotime($evento->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};' ><span>Comprar</span></button>     
                                            @endif
                                        @endif
                                        @if (($evento->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($evento->datafim)) || (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" style="cursor: not-allowed;" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};'  style="cursor: not-allowed;" ><span>Comprar</span></button>     
                                            @endif
                                        @endif
                                        
                                        <div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                            @if ($evento->estadoeventoid == 1)
                                                @if (strtotime(date('Y-m-d')) > strtotime($evento->datafim))
                                                    
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento))
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                

                                                @if (strtotime(date('Y-m-d')) >=  strtotime($evento->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($evento->datafim) && strtotime($evento->datainicio) != strtotime($evento->datafim))
                                                
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                @endif

                                                @if (strtotime($horaatual) < strtotime($evento->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio))
                                                <div class="rainbow-breve" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    
                                                </div> 
                                                @endif

                                                @if ( (strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $evento->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($evento->datainicio)))
                                                
                                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                        
                                                    </div> 
                                                @endif
                                            @else 
                                                <div class="rainbow-cancelado" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Cancelado!</p>
                                                    
                                                </div> 
                                            @endif
                                            
                                            
                                        </div>

                                        <br/>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="blog-content" data-aos="fade-left" data-aos-delay="200">
                                <img src="{{ asset("storage/imagens_eventos/vazioarte.svg") }}" alt="post-1">
                                <div class="blog-title">
                                    <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                        <h1>Sem evento</h1>
                                    </div>
                                    <button class="btneventos" onclick="window.location.href='#'" ><span>Vazio</span></button>
                                    
                                    <br/>
                                </div>
                            </div>
                            <div class="blog-content" data-aos="fade-right" data-aos-delay="200">
                                <img src="{{ asset("storage/imagens_eventos/vazioarte.svg") }}" alt="post-1">
                                <div class="blog-title">
                                    
                                    <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                                                                    
                                        <h1>Sem evento</h1>
                                    
                                    </div>
                                    <button class="btneventos" onclick="window.location.href='#'" ><span>Vazio</span></button>
                                    
                                    <br/>
                                </div>
                            </div>
                            
                    @endforeach                           
                @endif

                @if (count($eventos)==3)
                    @foreach ($eventos as $evento)
                            
                            <?php $i++; ?>
                            @php
                                                $datetime = new DateTime();
                                                $timezone = new DateTimeZone('Europe/Lisbon');
                                                $datetime->setTimezone($timezone);

                                                $horaatual =  $datetime->format('H:i:s');

                                                if(strtotime($evento->horafim) == strtotime("00:00:00")){
                                    $horafimevento = "23:59:00";
                                }else{
                                    $horafimevento = $evento->horafim;
                                }

                                            @endphp
                            
                            <?php if($i==1){ ?>
                                <div class="blog-content" data-aos="fade-right" data-aos-delay="200">
                                    <img src="{{ asset("storage/imagens_eventos/$evento->foto") }}" alt="post-1">
                                    <div class="blog-title">
                                        <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                            <h1>{{ $evento->evento }}</h1>
                                        </div>
                                        <button class="btneventos" onclick="window.location.href='{{ URL('eventos/detalhes', [$evento->idevento]) }}'" ><span>Detalhes</span></button>
                                        &nbsp;
                                        @if ($evento->estadoeventoid==1 && !(strtotime(date('Y-m-d')) > strtotime($evento->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                        @if ($evento->tpeventolugarid==2)
                                            <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" ><span>Comprar</span></button>
                                        
                                        @else
                                            <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};' ><span>Comprar</span></button>     
                                        @endif
                                    @endif
                                    @if (($evento->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($evento->datafim)) || (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                        @if ($evento->tpeventolugarid==2)
                                            <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" style="cursor: not-allowed;" ><span>Comprar</span></button>
                                        
                                        @else
                                            <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};'  style="cursor: not-allowed;" ><span>Comprar</span></button>     
                                        @endif
                                    @endif

                                        <div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                            @if ($evento->estadoeventoid == 1)
                                                @if (strtotime(date('Y-m-d')) > strtotime($evento->datafim))
                                                    
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento))
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                

                                                @if (strtotime(date('Y-m-d')) >=  strtotime($evento->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($evento->datafim) && strtotime($evento->datainicio) != strtotime($evento->datafim))
                                                
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                @endif

                                                @if (strtotime($horaatual) < strtotime($evento->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio))
                                                <div class="rainbow-breve" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    
                                                </div> 
                                                @endif

                                                @if ( (strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $evento->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($evento->datainicio)))
                                                
                                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                        
                                                    </div> 
                                                @endif
                                            @else 
                                                <div class="rainbow-cancelado" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Cancelado!</p>
                                                    
                                                </div> 
                                            @endif
                                            
                                            
                                        </div>
                                        <br/>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($i==2){ ?>
                                <div class="blog-content" data-aos="fade-in" data-aos-delay="200">
                                    <img src="{{ asset("storage/imagens_eventos/$evento->foto") }}" alt="post-1">
                                    <div class="blog-title">
                                        <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                            <h1>{{ $evento->evento }}</h1>
                                        </div>
                                        <button class="btneventos" onclick="window.location.href='{{ URL('eventos/detalhes', [$evento->idevento]) }}'" ><span>Detalhes</span></button>
                                        &nbsp;
                                        @if ($evento->estadoeventoid==1 && !(strtotime(date('Y-m-d')) > strtotime($evento->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};' ><span>Comprar</span></button>     
                                            @endif
                                        @endif
                                        @if (($evento->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($evento->datafim)) || (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" style="cursor: not-allowed;" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};'  style="cursor: not-allowed;" ><span>Comprar</span></button>     
                                            @endif
                                        @endif

                                        <div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                            @if ($evento->estadoeventoid == 1)
                                                @if (strtotime(date('Y-m-d')) > strtotime($evento->datafim))
                                                    
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento))
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                

                                                @if (strtotime(date('Y-m-d')) >=  strtotime($evento->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($evento->datafim) && strtotime($evento->datainicio) != strtotime($evento->datafim))
                                                
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                @endif

                                                @if (strtotime($horaatual) < strtotime($evento->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio))
                                                <div class="rainbow-breve" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    
                                                </div> 
                                                @endif

                                                @if ( (strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $evento->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($evento->datainicio)))
                                                
                                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                        
                                                    </div> 
                                                @endif
                                            @else 
                                                <div class="rainbow-cancelado" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Cancelado!</p>
                                                    
                                                </div> 
                                            @endif
                                            
                                            
                                        </div>
                                        
                                        <br/>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($i==3){?>
                                <div class="blog-content" data-aos="fade-left" data-aos-delay="200">
                                    <img src="{{ asset("storage/imagens_eventos/$evento->foto") }}" alt="post-1">
                                    <div class="blog-title">
                                        <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                            <h1>{{ $evento->evento }}</h1>
                                        </div>
                                        <button class="btneventos" onclick="window.location.href='{{ URL('eventos/detalhes', [$evento->idevento]) }}'" ><span>Detalhes</span></button>
                                        &nbsp;
                                        @if ($evento->estadoeventoid==1 && !(strtotime(date('Y-m-d')) > strtotime($evento->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};' ><span>Comprar</span></button>     
                                            @endif
                                        @endif
                                        @if (($evento->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($evento->datafim)) || (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" style="cursor: not-allowed;" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};'  style="cursor: not-allowed;" ><span>Comprar</span></button>     
                                            @endif
                                        @endif

                                        <div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                            @if ($evento->estadoeventoid == 1)
                                                @if (strtotime(date('Y-m-d')) > strtotime($evento->datafim))
                                                    
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento))
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                

                                                @if (strtotime(date('Y-m-d')) >=  strtotime($evento->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($evento->datafim) && strtotime($evento->datainicio) != strtotime($evento->datafim))
                                                
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                @endif

                                                @if (strtotime($horaatual) < strtotime($evento->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio))
                                                <div class="rainbow-breve" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    
                                                </div> 
                                                @endif

                                                @if ( (strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $evento->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($evento->datainicio)))
                                                
                                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                        
                                                    </div> 
                                                @endif
                                            @else 
                                                <div class="rainbow-cancelado" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Cancelado!</p>
                                                    
                                                </div> 
                                            @endif
                                            
                                            
                                        </div>
                                        
                                        <br/>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="blog-content" data-aos="fade-right" data-aos-delay="200">
                                <img src="{{ asset("storage/imagens_eventos/vazioarte.svg") }}" alt="post-1">
                                <div class="blog-title">
                                    <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                        <h1>Sem evento</h1>
                                    </div>
                                    <button class="btneventos" onclick="window.location.href='#'" ><span>Vazio</span></button>
                                    
                                    <br/>
                                </div>
                            </div>
                            
                    @endforeach                           
                @endif

                @if (count($eventos)>=4)
                    @foreach ($eventos as $evento)
                            
                            <?php $i++; ?>
                            <?php if($i>4){ $i=1; }?>
                            
                            @php
                                $datetime = new DateTime();
                                $timezone = new DateTimeZone('Europe/Lisbon');
                                $datetime->setTimezone($timezone);

                                $horaatual =  $datetime->format('H:i:s');
                                
                                if(strtotime($evento->horafim) == strtotime("00:00:00")){
                                    $horafimevento = "23:59:00";
                                }else{
                                    $horafimevento = $evento->horafim;
                                }
                                

                            @endphp

                            <?php if($i==1){ ?>
                                <div class="blog-content" data-aos="fade-right" data-aos-delay="200">
                                    <img src="{{ asset("storage/imagens_eventos/$evento->foto") }}" alt="post-1">
                                    <div class="blog-title">
                                        <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">   
                                            @if ($evento->tpeventolugarid==2)
                                                <h1 class="txteventoaprov">{{ $evento->evento }}</h1>    
                                        
                                            @else
                                                <h1 >{{ $evento->evento }}</h1>         
                                            @endif
                                                                                   
                                        </div>

                                        <button class="btneventos" onclick="window.location.href='{{ URL('eventos/detalhes', [$evento->idevento]) }}'" ><span>Detalhes</span></button>
                                        &nbsp;
                                        @if ($evento->estadoeventoid==1 && !(strtotime(date('Y-m-d')) > strtotime($evento->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};' ><span>Comprar</span></button>     
                                            @endif
                                        @endif
                                        @if (($evento->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($evento->datafim)) || (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" style="cursor: not-allowed;" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};'  style="cursor: not-allowed;" ><span>Comprar</span></button>     
                                            @endif
                                        @endif

                                        <div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                            @if ($evento->estadoeventoid == 1)
                                                @if (strtotime(date('Y-m-d')) > strtotime($evento->datafim))
                                                    
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento))
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                

                                                @if (strtotime(date('Y-m-d')) >=  strtotime($evento->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($evento->datafim) && strtotime($evento->datainicio) != strtotime($evento->datafim))
                                                
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                @endif

                                                @if (strtotime($horaatual) < strtotime($evento->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio))
                                                <div class="rainbow-breve" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    
                                                </div> 
                                                @endif

                                                @if ( (strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $evento->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($evento->datainicio)))
                                                
                                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                        
                                                    </div> 
                                                @endif
                                            @else 
                                                <div class="rainbow-cancelado" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Cancelado!</p>
                                                    
                                                </div> 
                                            @endif
                                            
                                            
                                        </div>
                                        
                                        <br/>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($i==2){ ?>
                                <div class="blog-content" data-aos="fade-in" data-aos-delay="200">
                                    <img src="{{ asset("storage/imagens_eventos/$evento->foto") }}" alt="post-1">
                                    <div class="blog-title">
                                        <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                            @if ($evento->tpeventolugarid==2)
                                                <h1 class="txteventoaprov">{{ $evento->evento }}</h1>    
                                        
                                            @else
                                                <h1 >{{ $evento->evento }}</h1>         
                                            @endif
                                        </div>
                                        <button class="btneventos" onclick="window.location.href='{{ URL('eventos/detalhes', [$evento->idevento]) }}'" ><span>Detalhes</span></button>
                                        &nbsp;
                                        @if ($evento->estadoeventoid==1 && !(strtotime(date('Y-m-d')) > strtotime($evento->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};' ><span>Comprar</span></button>     
                                            @endif
                                        @endif
                                        @if (($evento->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($evento->datafim)) || (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" style="cursor: not-allowed;" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};'  style="cursor: not-allowed;" ><span>Comprar</span></button>     
                                            @endif
                                        @endif

                                        <div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                            @if ($evento->estadoeventoid == 1)
                                                @if (strtotime(date('Y-m-d')) > strtotime($evento->datafim))
                                                    
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento))
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                

                                                @if (strtotime(date('Y-m-d')) >=  strtotime($evento->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($evento->datafim) && strtotime($evento->datainicio) != strtotime($evento->datafim))
                                                
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                @endif

                                                @if (strtotime($horaatual) < strtotime($evento->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio))
                                                <div class="rainbow-breve" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    
                                                </div> 
                                                @endif

                                                @if ( (strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $evento->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($evento->datainicio)))
                                                
                                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                        
                                                    </div> 
                                                @endif
                                            @else 
                                                <div class="rainbow-cancelado" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Cancelado!</p>
                                                    
                                                </div> 
                                            @endif
                                            
                                            
                                        </div>
                                        
                                        <br/>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($i==3){?>
                                <div class="blog-content" data-aos="fade-left" data-aos-delay="200">
                                    <img src="{{ asset("storage/imagens_eventos/$evento->foto") }}" alt="post-1">
                                    <div class="blog-title">
                                        <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                            @if ($evento->tpeventolugarid==2)
                                                <h1 class="txteventoaprov">{{ $evento->evento }}</h1>    
                                        
                                            @else
                                                <h1 >{{ $evento->evento }}</h1>         
                                            @endif
                                        </div>
                                        <button class="btneventos" onclick="window.location.href='{{ URL('eventos/detalhes', [$evento->idevento]) }}'" ><span>Detalhes</span></button>
                                        &nbsp;
                                        @if ($evento->estadoeventoid==1 && !(strtotime(date('Y-m-d')) > strtotime($evento->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};' ><span>Comprar</span></button>     
                                            @endif
                                        @endif
                                        @if (($evento->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($evento->datafim)) || (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" style="cursor: not-allowed;" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};'  style="cursor: not-allowed;" ><span>Comprar</span></button>     
                                            @endif
                                        @endif

                                        <div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                            @if ($evento->estadoeventoid == 1)
                                                @if (strtotime(date('Y-m-d')) > strtotime($evento->datafim))
                                                    
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento))
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                

                                                @if (strtotime(date('Y-m-d')) >=  strtotime($evento->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($evento->datafim) && strtotime($evento->datainicio) != strtotime($evento->datafim))
                                                
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                @endif

                                                @if (strtotime($horaatual) < strtotime($evento->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio))
                                                <div class="rainbow-breve" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    
                                                </div> 
                                                @endif

                                                @if ( (strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $evento->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($evento->datainicio)))
                                                
                                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                        
                                                    </div> 
                                                @endif
                                            @else 
                                                <div class="rainbow-cancelado" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Cancelado!</p>
                                                    
                                                </div> 
                                            @endif
                                            
                                            
                                        </div>
                                        
                                        <br/>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($i==4){?>
                                <div class="blog-content" data-aos="fade-right" data-aos-delay="200">
                                    <img src="{{ asset("storage/imagens_eventos/$evento->foto") }}" alt="post-1">
                                    <div class="blog-title">
                                        <div class="container d-flex justify-content-center align-items-center" style="width: 248px; height: 36px;">                                            
                                            @if ($evento->tpeventolugarid==2)
                                                <h1 class="txteventoaprov">{{ $evento->evento }}</h1>    
                                        
                                            @else
                                                <h1 >{{ $evento->evento }}</h1>         
                                            @endif
                                        </div>
                                        <button class="btneventos" onclick="window.location.href='{{ URL('eventos/detalhes', [$evento->idevento]) }}'" ><span>Detalhes</span></button>
                                        &nbsp;
                                        @if ($evento->estadoeventoid==1 && !(strtotime(date('Y-m-d')) > strtotime($evento->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};' ><span>Comprar</span></button>     
                                            @endif
                                        @endif
                                        @if (($evento->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($evento->datafim)) || (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
                                            @if ($evento->tpeventolugarid==2)
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" id="{{ $evento->idevento }}" style="cursor: not-allowed;" ><span>Comprar</span></button>
                                            
                                            @else
                                                <button class="btneventos evcomprar" disabled tplugarevento="{{ $evento->tpeventolugarid }}" onclick='location.href = {!! json_encode($evento->linkcompra) !!};'  style="cursor: not-allowed;" ><span>Comprar</span></button>     
                                            @endif
                                        @endif
                                        

                                        
                                        <div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                            @if ($evento->estadoeventoid == 1)
                                                @if (strtotime(date('Y-m-d')) > strtotime($evento->datafim))
                                                    
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) == strtotime($evento->datafim) && strtotime($horaatual) > strtotime($horafimevento))
                                                    <div class="rainbow-terminado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                                    </div> 
                                                @endif
                                                

                                                @if (strtotime(date('Y-m-d')) >=  strtotime($evento->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($evento->datafim) && strtotime($evento->datainicio) != strtotime($evento->datafim))
                                                
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                 
                                                @endif
                                                
                                                @if (strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio) && strtotime($evento->datainicio) == strtotime($evento->datafim) && strtotime($horaatual) >= strtotime($evento->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))
                                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div> 
                                                @endif

                                                @if (strtotime($horaatual) < strtotime($evento->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($evento->datainicio))
                                                <div class="rainbow-breve" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    
                                                </div> 
                                                @endif

                                                @if ( (strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $evento->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($evento->datainicio)))
                                                
                                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                        
                                                    </div> 
                                                @endif
                                            @else 
                                                <div class="rainbow-cancelado" >
                                                    <p style="font-weight: bold; color: #515151; margin-top: -6%;">Cancelado!</p>
                                                    
                                                </div> 
                                            @endif
                                            
                                            
                                        </div>
                                                                           
                                        
                                        <br/>
                                    </div>
                                </div>
                            <?php } ?>
                            
                    @endforeach                           
                @endif

            </div>
            
            <div class="owl-navigation">                       
                <span class="owl-nav-prev" ><i class="fas fa-long-arrow-alt-left"></i></span>
                <span class="owl-nav-next"><i class="fas fa-long-arrow-alt-right"></i></span>
            </div>
        </div>
    </div>
</section>

@if (!Auth::check())
    <script>
        $(document).on('click', '.evcomprar', function(){
			window.location = "/login";

		});
    </script>
@endif