<?php
namespace Newscast\Services;

use Twig\Environment;

class TwigService extends Service {
	public mixed $twig;

	public function __construct() {
		$this->twig = null;
	}

	public function get( $folder = 'public' ): Environment {
		if ( null === $this->twig ) {
			$folder_path = empty( $folder ) ? APP_PATH . '/views' : APP_PATH . '/views/' . $folder;

			$loader     = new \Twig\Loader\FilesystemLoader( $folder_path );
			$this->twig = new \Twig\Environment(
				$loader,
				array(
					'debug' => true,
				)
			);

			$this->twig->addExtension( new \Twig\Extension\DebugExtension() );
		}

		return $this->twig;
	}
}
