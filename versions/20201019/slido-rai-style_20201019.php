<?php
/*
NOTA! nella seguente classe
	.rai-style-post-image{
		overflow: hidden;
		padding-top: 55%;
	}
l'overflow:hidden è importante in fase di caricamento.
Senza specificare questa proprietà si ha una visualizzazione flash
del contenuto prima della sua corretta collocazione

IN GENERALE: alcune classi che sembrano inutili quando la pagina
è stata caricata, possono influire molto in fase di caricamento.
QUINDI dopo avere modificato o cancellato delle classi verificare
eventuali cambiamenti in fase di caricamento

*/


?>
	<style>

		.slido-body {
			padding: 11px;
			background: #232323;
		}

		.slido-container {
			margin-bottom: 20px !important;
		}

		.slido-flex-box {
			display: none;
			/*display: flex;
			justify-content: center;*/
		}

		.slido-flex-box img{
			/*width: auto;
			object-fit: contain;*/
		}


</style>

<style>
	.slick-dots li button:before {
		color: #ffffff;
	}	
	
	.slick-dots li.slick-active button:before
	{
		opacity: 1;
		color: #f00;
	}	

	.rapporto-fisso {
		padding-top: 56%;
		background: red;
	}
	.container-titolo{
		position: relative;
		padding-top:40%;
	}
	
	a.container-titolo{
		display:block;
	}

	.slido-rai-title {
		text-align: center;
		position: absolute;
		color: white;
		bottom: 0px;
		padding: 7px;
		font-size: 15px;
	}	
	
	.accavallo {
		position: absolute;
		top: -11px;
		background: #d73135;
		padding: 3px 7px;
		right: 0;
		color: white;
		text-transform: uppercase;
	}
	
	.rai-style-post-image{
		/*overflow: hidden;
		padding-top: 55%;*/
	}
	
	.rai-feat-img-container{ 
		/*width: 100%;
    	height: 57%;
		position: absolute;
		top: 0px;
		left: 0px;*/
	}	
	
	.slido-flex-center{
		height: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
	}

</style>
<?php

