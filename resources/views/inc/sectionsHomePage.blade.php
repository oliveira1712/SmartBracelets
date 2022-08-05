<section class="hero" id="hero">

    <div class="container">

        <h2 class="sub-headline">

            <span class="first-letter">W</span>elcome

        </h2>

        <h1 class="headline">Smart Bracelets</h1>

        <div class="headline-description">

            <div class="separator"> <!--Para o *-->

                <div class="line line-left"></div>

                <div class="asterisk"><i class="fas fa-asterisk"></i></div>

                <div class="line line-right"></div>

            </div>

            <div class="single-animation">

                <h5>Gestão de Eventos</h5>

                

            </div>

        </div>

    </div>

</section>



<!--Hero ends-->

<section class="discover-our-idea">

    <div class="container">

        <div class="smbr-info">

            <div class="smbr-description padding-right animate-left">

                <div class="global-headline">

                    <h2 class="sub-headline">

                        <span class="first-letter">D</span>escobre

                    </h2>

                    <h1 class="headline headline-dark">a nossa ideia</h1>

                    <div class="asterisk"><i class="fas fa-asterisk"></i></div>

                </div>

                <p>

                    Este projeto foi desenvolvido por David Martins e Gonçalo Oliveira do 12ºC do curso
                    Tecnico de Gestão e Programação de Sistemas Informaticos no âmbito da prova de aptidão
                    profissional.
                    <br> 
                    <a href="">App Móvel</a>
                    <br>
                    Coordenação:
                    <br>
                    <i class="fas fa-chalkboard-teacher"></i> Fátima Pais
                    
                    <i class="fas fa-chalkboard-teacher"></i> José Paulo Sá
                    <br>
                    <i class="fas fa-chalkboard-teacher"></i> João Paulo Barros
                    
                    <i class="fas fa-chalkboard-teacher"></i> Luís Pereira
                </p>
                
                

                <a href="#footersobre" class="btnc body-btnc">Sobre Nós</a>

                {{-- Logos da escola e poch --}}
                <div id="logos-escola-poch" class="image-group padding-right animate-left" style="margin-top: 2rem;">
                    <img src="{{ asset('storage/imgsExtra/logoserafimleite.png') }}" style="width: 60%;" alt="">

                    <img src="{{ asset('storage/imgsExtra/logopoch.png') }}" alt="" style="margin-top: 2rem">
                </div>

            </div>

            <div class="smbr-info-img animate-right">

                <img src="{{ asset('storage/imgsHomePage/concerto4.jpg') }}" alt="">

            </div>

        </div>

    </div>

</section>

<!--Descobre a nossa ideia acaba-->

<section class="eventos-variados between">

    <div class="container">

        <div class="global-headline">

            <div class="animate-top">

                <h2 class="sub-headline">

                    <span class="first-letter">E</span>ventos

                </h2>

            </div>

            <div class="animate-bottom">

                <h1 class="headline headline">Variados</h1>

            </div>                               

        </div>

    </div>

</section>

<!-- Eventos variados acaba -->

<section class="discover-our-events">

    <div class="container">

        <div class="smbr-info">

            <div class="image-group padding-right animate-left">

                <img src="{{ asset('storage/imgsHomePage/eventoconcerto.jpg') }}" alt="">

                <img src="{{ asset('storage/imgsHomePage/eventoarte.jpg') }}" alt="">

                <img src="{{ asset('storage/imgsHomePage/eventoteatro.jpg') }}" alt="">

                <img src="{{ asset('storage/imgsHomePage/eventomediaval.jpg') }}" alt="">

            </div>

            <div class="smbr-description animate-right">

                <div class="global-headline">

                    <h2 class="sub-headline">

                        <span class="first-letter">D</span>escobre

                    </h2>

                    <h1 class="headline headline-dark">Eventos</h1>

                    <div class="asterisk"><i class="fas fa-asterisk"></i></div>

                </div>

                <p>Neste website encontram-se todo o tipo de eventos desde música, teatro, arte e desporto. Além disso é possível ver os seus detalhes e comprar bilhetes para os mesmos

                </p>

                <a href="{{ url('eventos/pesquisar') }}" class="btnc body-btnc">Ver todos os eventos</a>

            </div>

        </div>

    </div>

</section>

<!--Descobre os eventos acaba-->

<section class="perfect-blend between">

    <div class="container">

        <div class="global-headline">

            <div class="animate-top">

                <h2 class="sub-headline">

                    <span class="first-letter">P</span>ulseiras

                </h2>

            </div>

            <div class="animate-bottom">

                <h1 class="headline headline">RFID</h1>

            </div>                               

        </div>

    </div>

</section>



<!-- Pulseiras RFID acaba -->

<section class="escolhe-pulseira">

    <div class="container">

        <div class="smbr-info">

            <div class="smbr-description padding-right animate-left">

                <div class="global-headline">

                    <h2 class="sub-headline">

                        <span class="first-letter">E</span>scolhe

                    </h2>

                    <h1 class="headline headline-dark">a tua pulseira</h1>

                    <div class="asterisk"><i class="fas fa-asterisk"></i></div>

                </div>

                <p>

                    As pulseiras RFID permitem e promovem uma melhor organização de eventos, além disso é possivel verificar o histórico de compras e de entradas e saidas de cada pulseira.

                </p>

                <a href="{{ url('eventos/musica') }}" class="btnc body-btnc">Compra já</a>

            </div>

            <div class="image-group">

                <img class="animate-top" src="storage/imgsHomePage/bracelet1.jpg" alt="">

                <img class="animate-bottom" src="storage/imgsHomePage/bracelet2.jpg" alt="">

            </div>

        </div>

    </div>

</section>

<!-- Escolhe pulseira acaba -->