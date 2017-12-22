<?php
/*
 *  IE needs 512+ bytes: http://blogs.msdn.com/b/ieinternals/archive/2010/08/19/http-error-pages-in-internet-explorer.aspx
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
    <meta charset="<?php bloginfo( 'charset' ) ?>">
    <title>Page Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

			* {
					line-height: 1.2;
					margin: 0;
			}

			html {
					color: #888;
					display: table;
					font-family: sans-serif;
					height: 100%;
					text-align: center;
					width: 100%;
			}

			body {
					display: table-cell;
					vertical-align: middle;
					margin: 2em auto;
			}

			h1 {
					color: #555;
					font-size: 2em;
					font-weight: 400;
			}

			img {
					margin-bottom: 30px;
					max-width: 180px;
			}

			p {
					margin: 0 auto;
					width: 280px;
			}

			@media only screen and (max-width: 280px) {

					body, p {
							width: 95%;
					}

					h1 {
							font-size: 1.5em;
							margin: 0 0 0.3em;
					}

			}

    </style>
	</head>
	<body itemscope itemtype="http://schema.org/WebPage">
    <h1><?php _e( 'Page Not Found', TEXT_DOMAIN ) ?></h1>
    <p><?php _e( 'Sorry, but the page you were trying to view does not exist.', TEXT_DOMAIN ) ?></p>
	</body>
</html>
