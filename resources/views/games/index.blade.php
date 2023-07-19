<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ \App\Settings::find(1)->app_name }} | Games </title>
	<!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ (\App\Settings::find(1)->logo == null) ? url('/admin/assets/images/logo-icon.png') : \App\Settings::find(1)->logo }}"/>
</head>
<body>
	<style>
		@import 'https://fonts.googleapis.com/css?family=Open+Sans:600,700';

		* {font-family: 'Open Sans', sans-serif;}

		.rwd-table {
		  margin: auto;
		  width: 70%;
		  border-collapse: collapse;
		}

		.rwd-table tr:first-child {
		  border-top: none;
		  background: #428bca;
		  color: #fff;
		}

		.rwd-table tr {
		  border-top: 1px solid #ddd;
		  border-bottom: 1px solid #ddd;
		  background-color: #f5f9fc;
		}

		.rwd-table tr:nth-child(odd):not(:first-child) {
		  background-color: #ebf3f9;
		}

		.rwd-table th {
		  display: none;
		}

		.rwd-table td {
		  display: block;
		}

		.rwd-table td:first-child {
		  margin-top: .5em;
		}

		.rwd-table td:last-child {
		  margin-bottom: .5em;
		}

		.rwd-table td:before {
		  content: attr(data-th) ": ";
		  font-weight: bold;
		  width: 120px;
		  display: inline-block;
		  color: #000;
		}

		.rwd-table th,
		.rwd-table td {
		  text-align: left;
		}

		.rwd-table {
		  color: #333;
		  border-radius: .4em;
		  overflow: hidden;
		}

		.rwd-table tr {
		  border-color: #bfbfbf;
		}

		.rwd-table th,
		.rwd-table td {
		  padding: .5em 1em;
		}
		@media screen and (max-width: 601px) {
		  .rwd-table tr:nth-child(2) {
		    border-top: none;
		  }
		}
		@media screen and (min-width: 600px) {
		  .rwd-table tr:hover:not(:first-child) {
		    background-color: #d8e7f3;
		  }
		  .rwd-table td:before {
		    display: none;
		  }
		  .rwd-table th,
		  .rwd-table td {
		    display: table-cell;
		    padding: .25em .5em;
		  }
		  .rwd-table th:first-child,
		  .rwd-table td:first-child {
		    padding-left: 0;
		  }
		  .rwd-table th:last-child,
		  .rwd-table td:last-child {
		    padding-right: 0;
		  }
		  .rwd-table th,
		  .rwd-table td {
		    padding: 1em !important;
		  }
		}


		/* THE END OF THE IMPORTANT STUFF */

		/* Basic Styling */
		body {
		background: #4B79A1;
		background: -webkit-linear-gradient(to left, #4B79A1 , #283E51);
		background: linear-gradient(to left, #4B79A1 , #283E51);        
		}
		h1 {
		  text-align: center;
		  font-size: 2.4em;
		  color: #f2f2f2;
		}
		.container {
		  display: block;
		  text-align: center;
		}
		h3 {
		  display: inline-block;
		  position: relative;
		  text-align: center;
		  font-size: 1.5em;
		  color: #cecece;
		}
		h3:before {
		  content: "\25C0";
		  position: absolute;
		  left: -50px;
		  -webkit-animation: leftRight 2s linear infinite;
		  animation: leftRight 2s linear infinite;
		}
		h3:after {
		  content: "\25b6";
		  position: absolute;
		  right: -50px;
		  -webkit-animation: leftRight 2s linear infinite reverse;
		  animation: leftRight 2s linear infinite reverse;
		}
		@-webkit-keyframes leftRight {
		  0%    { -webkit-transform: translateX(0)}
		  25%   { -webkit-transform: translateX(-10px)}
		  75%   { -webkit-transform: translateX(10px)}
		  100%  { -webkit-transform: translateX(0)}
		}
		@keyframes leftRight {
		  0%    { transform: translateX(0)}
		  25%   { transform: translateX(-10px)}
		  75%   { transform: translateX(10px)}
		  100%  { transform: translateX(0)}
		}
		.game-button {
		  position: relative;
		  top: 0px;
		  cursor: pointer;
		  text-decoration: none !important;
		  outline: none !important;
		  font-family: 'Carter One', sans-serif;
		  font-size: 20px;
		  line-height: 1.5em;
		  letter-spacing: .1em;
		  text-shadow: 2px 2px 1px #0066a2, -2px 2px 1px #0066a2, 2px -2px 1px #0066a2, -2px -2px 1px #0066a2, 0px 2px 1px #0066a2, 0px -2px 1px #0066a2, 0px 4px 1px #004a87, 2px 4px 1px #004a87, -2px 4px 1px  #004a87;
		  border: none;
		  margin: 15px 15px 30px;
		  background: repeating-linear-gradient( 45deg, #3ebbf7, #3ebbf7 5px, #45b1f4 5px, #45b1f4 10px);
		  border-bottom: 3px solid rgba(16, 91, 146, 0.5);
		  border-top: 3px solid rgba(255,255,255,.3);
		  color: #fff !important;
		  border-radius: 8px;
		  padding: 8px 15px 10px;
		}
		.game-button::before {
			content: '';
			height: 10%;
			position: absolute;
			width: 40%;
			background: #fff;
			right: 13%;
			top: -3%;
			border-radius: 99px;
		}
		.game-button::after {
			content: '';
			height: 10%;
			position: absolute;
			width: 5%;
			background: #fff;
			right: 5%;
			top: -3%;
			border-radius: 99px;
		}
		.img-thumbnail {
			border: 1px solid #584f4f;
    		padding: 5px;
    		border-radius: 5px;
		}
	</style>
	<div class="container">
		<h3>Games Lists</h3>
		<table class="rwd-table">
			<tbody>
				<tr>
					<th style="text-align: center;">Name</th>
					<th style="text-align: center;">Image</th>
					<th style="text-align: center;">Action</th>
				</tr>
				<tr style="height: 120px;">
					<td style="text-align: center;">Menja</td>
					<td style="text-align: center;">
						<img src="/admin/assets/games/menja.jpg" width="180" class="img-thumbnail" height="100" alt="Menja">
					</td>
					<td style="text-align: center;">
						<a href="/games/menja" class="game-button">Start It!</a>
					</td>
				</tr>
				<tr style="height: 120px;">
					<td style="text-align: center;">Color Blast</td>
					<td style="text-align: center;">
						<img src="/admin/assets/games/color-blast.jpg" width="180" class="img-thumbnail" height="100" alt="Color Blast">
					</td>
					<td style="text-align: center;">
						<a href="/games/color-blast" class="game-button">Start It!</a>
					</td>
				</tr>
				<tr style="height: 120px;">
					<td style="text-align: center;">Snake</td>
					<td style="text-align: center;">
						<img src="/admin/assets/games/snake.jpg" width="180" class="img-thumbnail" height="100" alt="Snake">
					</td>
					<td style="text-align: center;">
						<a href="/games/snake" class="game-button">Start It!</a>
					</td>
				</tr>
				{{-- <tr style="height: 120px;">
					<td style="text-align: center;">Tower Blocks</td>
					<td style="text-align: center;">
						<img src="/admin/assets/games/tower-blocks.jpg" width="180" class="img-thumbnail" height="100" alt="Tower Blocks">
					</td>
					<td style="text-align: center;">
						<a href="/games/tower-blocks" class="game-button">Start It!</a>
					</td>
				</tr> --}}
				{{-- <tr style="height: 120px;">
					<td style="text-align: center;">Defense Planet</td>
					<td style="text-align: center;">
						<img src="/admin/assets/games/defense-planet.jpg" width="180" class="img-thumbnail" height="100" alt="Defense Planet">
					</td>
					<td style="text-align: center;">
						<a href="/games/defense-planet" class="game-button">Start It!</a>
					</td>
				</tr> --}}
				<tr style="height: 120px;">
					<td style="text-align: center;">Flip Card</td>
					<td style="text-align: center;">
						<img src="/admin/assets/games/flip-card.jpg" width="180" class="img-thumbnail" height="100" alt="Flip Card">
					</td>
					<td style="text-align: center;">
						<a href="/games/flip-card" class="game-button">Start It!</a>
					</td>
				</tr>
				{{-- <tr style="height: 120px;">
					<td style="text-align: center;">Color On</td>
					<td style="text-align: center;">
						<img src="/admin/assets/games/color-on.jpg" width="180" class="img-thumbnail" height="100" alt="Color On">
					</td>
					<td style="text-align: center;">
						<a href="/games/color-on" class="game-button">Start It!</a>
					</td>
				</tr> --}}
			</tbody>
		</table>
	</div>
</body>
</html>