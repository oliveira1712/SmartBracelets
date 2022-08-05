



	<div id="cd-shadow-layer"></div>



	<div id="cd-cart" style="">

		

		<!-- O codigo esta no controller ManipularBilheteController na função getBilhetes -->

		<div class="fancy-spinner" id="loader" style="display: none;">

			<div class="ring"></div>

			<div class="ring"></div>

			<div class="dot"></div>

		</div>



	</div> <!-- cd-cart -->



	



	<script>



	



	

	$(document).on('click', '.evcomprar', function(){

		var tplugar = $(this).attr('tplugarevento');



		if(tplugar!=1){

			idevento = $(this).attr('id');



			triggercarrinho.classList.remove("slidedown");	

			triggercarrinho.classList.remove("slideup");



			comprar_bilhete(idevento);
			
				
			
			triggercarrinho.classList.add("slidedown");

			triggercarrinho.addEventListener('transitionend', function() {

				conta_nrbilhetes();							
				mostra_bilhetes();

				triggercarrinho.classList.add("slideup");

			});

		}

			

            



		});





		$(document).on('click', '.detcomprar', function(){

		

			var tplugar = $(this).attr('tplugarevento');



		if(tplugar!=1){

			idevento = $(this).attr('id');



            triggercarrinho.classList.remove("slidedown");	

			triggercarrinho.classList.remove("slideup");



			/* comprar_bilhete(idevento); */
			
            triggercarrinho.classList.add("slidedown");

            triggercarrinho.addEventListener('transitionend', function() {

									
				conta_nrbilhetes(); 
                triggercarrinho.classList.add("slideup");

            });

		}



		});

	

		mostra_bilhetes();

	  function mostra_bilhetes()

	  {

		

		var action = 'fetch_data';

		let iduser = document.getElementById("iduser").value;

		var auxdata;

		$('#cd-cart').html(auxdata);

		$.ajax(

		  

		  {

			url:"{{ route('Bilhete.getBilhetes') }}",

			method:"POST",

			data:{

			  "_token": "{{ csrf_token() }}",

			  action:action, 

			  iduser:iduser

			  },

			  beforeSend: function(){

					// Show image container

					$("#loader").show();

				},

			success:function(data){

				$('#cd-cart').html(data);

				auxdata = data;

				//$("#loader").hide();

			}

		});

	  }



	  	function comprar_bilhete_btnadicionar(idevento)

		{

			

		var action = 'fetch_data';

		

		let iduser = document.getElementById("iduser").value; //o input hidden estao no layouts.main

		

		$.ajax(

			

			{

			url:"{{ route('Bilhete.buyTicket') }}",

			method:"POST",

			data:{

				"_token": "{{ csrf_token() }}",

				action:action, 

				idevento:idevento, 

				iduser:iduser

				},

			success:function(data){

				if(data==0){

					Swal.fire({

						type: 'warning',

						customClass: 'swal-wide',

						title: '<h3>Stock Insuficiente</h3>',

						html: '<h2>Não temos pulseiras em stock! Espere até reabastecermos mais!</h2>',

						timer: 2500

					});

				}

				mostra_bilhetes();

			}

		});

		}



		function remover_bilhete_retirarbtn(idevento,idpulseira)

		{

			

		var action = 'fetch_data';

		

		let iduser = document.getElementById("iduser").value; //o input hidden estao no layouts.main

		

		$.ajax(

			

			{

				url:"{{ route('Bilhete.removeTicket') }}",

				method:"POST",

				data:{

					"_token": "{{ csrf_token() }}",

					action:action, 

					idevento:idevento, 

					idpulseira:idpulseira, 

					iduser:iduser

					},

				success:function(data){

					//$('.filter_data').html(data);

				}

			});

		}



		function remover_bilhetes(idevento)

		{

			

		var action = 'fetch_data';

		

		let iduser = document.getElementById("iduser").value; //o input hidden estao no layouts.main

		

		$.ajax(

			

			{

				url:"{{ route('Bilhete.removeTickets') }}",

				method:"POST",

				data:{

					"_token": "{{ csrf_token() }}",

					action:action, 

					idevento:idevento, 

					iduser:iduser

					},

				success:function(data){

					//$('.filter_data').html(data);

				}

			});

		}





		function conta_nrbilhetes()

		{

			

		var action = 'fetch_data';

		

		let iduser = document.getElementById("iduser").value; //o input hidden estao no layouts.main

		

		$.ajax(

			

			{

				url:"{{ route('Bilhete.countTickets') }}",

				method:"POST",

				data:{

					"_token": "{{ csrf_token() }}",

					action:action, 

					iduser:iduser

					},

				success:function(data){

					$('#triggercarrinho span').html(data);

					

				}

				

			});

		}



		function comprar_bilhete(idevento)

		{

			

		var action = 'fetch_data';

		

		let iduser = document.getElementById("iduser").value; //o input hidden estao no layouts.main

		

		$.ajax(

			

			{

			url:"{{ route('Bilhete.buyTicket') }}",

			method:"POST",

			data:{

				"_token": "{{ csrf_token() }}",

				action:action, 

				idevento:idevento, 

				iduser:iduser

				},

			success:function(data){

				if(data==0){

					Swal.fire({

						type: 'warning',

						customClass: 'swal-wide',

						title: '<h3>Stock Insuficiente</h3>',

						html: '<h2>Não temos pulseiras em stock! Espere até reabastecermos mais!</h2>',

						timer: 2500

					});

				}else{

					Swal.fire({

						type: 'success',

						customClass: 'swal-wide',

						title: '<h3>Sucesso</h3>',

						html: '<h2 style="color: #72A276;">Este bilhete foi adicionado ao carrinho</h2>',

						timer: 1500

					});

				}

				

			}

		});

		}



	  let ideventoadicionar;

	  let ideventoretirar;

	  let idpulseiraretirar;



	  const triggercarrinho = document.querySelector("#triggercarrinho span");

			

		$(document).on('click', '.adicionar', function(event){

			if(!event.detail || event.detail == 1){//activate on first click only to avoid hiding again on multiple clicks

					// code here. // It will execute only once on multiple clicks

				

				ideventoadicionar = $(this).attr('id');

				

				triggercarrinho.classList.remove("slidedown");	

				triggercarrinho.classList.remove("slideup");



				const itemadd = document.querySelector("#lievnt"+ideventoadicionar);

				itemadd.classList.add("slideadd");

				comprar_bilhete_btnadicionar(ideventoadicionar);



				itemadd.addEventListener('transitionend', function() {				

					triggercarrinho.classList.add("slidedown");

					triggercarrinho.addEventListener('transitionend', function() {					

						triggercarrinho.classList.add("slideup");

					});

					mostra_bilhetes();

					

					conta_nrbilhetes();



					if (window.location.href.indexOf("eventos/checkout") > -1) {

						

						mostra_bilhetes_checkout();

					}

				});



			}

		});



		



		$(document).on('click', '.retirar', function(){

			if(!event.detail || event.detail == 1){

				ideventoretirar = $(this).attr('id');

				idpulseiraretirar = $(this).attr('name');



				triggercarrinho.classList.remove("slidedown");	

				triggercarrinho.classList.remove("slideup");



				const itemremove = document.querySelector("#lievnt"+ideventoretirar);

				itemremove.classList.add("slideremove");

				remover_bilhete_retirarbtn(ideventoretirar,idpulseiraretirar);



				itemremove.addEventListener('transitionend', function() {

					triggercarrinho.classList.add("slidedown");

					triggercarrinho.addEventListener('transitionend', function() {

						triggercarrinho.classList.add("slideup");

					});

					mostra_bilhetes();

					conta_nrbilhetes();

					

					if (window.location.href.indexOf("eventos/checkout") > -1) {						

						mostra_bilhetes_checkout();

					}

				});

			}

		});



		$(document).on('click', '.removerbilhetes', function(){

			ideventoretirarbilhetes = $(this).attr('id');

			const itemremoveall = document.querySelector("#lievnt"+ideventoretirarbilhetes);



			triggercarrinho.classList.remove("slidedown");	

			triggercarrinho.classList.remove("slideup");



			itemremoveall.classList.add("falldelete");

			itemremoveall.addEventListener('transitionend', function() {

				remover_bilhetes(ideventoretirarbilhetes);



				triggercarrinho.classList.add("slidedown");

				triggercarrinho.addEventListener('transitionend', function() {

					triggercarrinho.classList.add("slideup");

				});

				mostra_bilhetes();

				conta_nrbilhetes();



				if (window.location.href.indexOf("eventos/checkout") > -1) {						

					mostra_bilhetes_checkout();

				}

			});

			

		});

		

	  </script>



