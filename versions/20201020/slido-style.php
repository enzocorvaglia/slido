<?php



?>
		<style>
			
			.slido-body {
				padding: 11px;
				background: #232323;
			}
			
			h3.slido-header {
				color: #d73135;
				text-align: center;
				padding-bottom: 5px;
				margin-bottom: 0px;
				font-weight: 600;
				text-transform: lowercase;
			}				
			
			.slido-container {
				margin-bottom: 20px !important;
			}

			.slido-flex-container {
				display: flex !important;
				flex-wrap: wrap;
			}

			.slido-slider {
				width: 100%;
				margin: 0 auto;
			}	

			.slido-flex-box {
				display: flex;
				justify-content: center;
				/*transition: transform .2s; */  /* Animation */
			}

			.slido-flex-box:hover{
				/*transform:  scale(1.1);*/
			}

			.slido-flex-box img{
				width: auto;
				object-fit: contain;
			}
			.slido-post-image {
				margin: 0;
				position: relative;
				margin-bottom: 0 !important;
				margin-right: 0px !important;
				overflow: hidden;
				padding-top: 100%;
			}

			.slido-title_1 {
				padding: 15px;
				/* border-top: 1px #75080a solid; */
				text-align: center;
				position: absolute;
				bottom: 0px;
				left: 0px;
				/* background: rgb(35 35 35 / 63%); */
				color: white;
				/* text-transform: uppercase; */
				/* font-size: large; */
				/*font-weight: 600;*/
			}
			.slido-title_2 {
				position: absolute;
				top: 0px;
				left: 0px;
				padding: 0 7px;
				background-color: #c7110d94;
				color: white;
				font-size: 14px;
				margin: 11px;
				text-align: center;
				transition: 1s;
				opacity: 0;
			}
			.slido-post-image a, .slido-post-image a:hover{
				color: white;
			}
			.slido-flex-box a.fixed-ratio-container {
				width: 100%;
				height: 55%;
			}
			
			.slick-dots li button:before {
				color: #ffffff;
			}			
			.slick-dots li.slick-active button:before
			{
				opacity: 1;
				color: #f00;
			}
			
			.slido-title_3 {
				position: absolute;
				bottom: -15px;
				background: #d73135;
				padding: 3px 7px;
				right: 0;
				color: white;
				text-transform: uppercase;
			}	
	</style>

<?php

