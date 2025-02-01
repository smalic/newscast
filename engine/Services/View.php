<?php
namespace Newscast\Services;

use Twig\Environment;

class ViewService extends Service {
	protected Environment $twig;

	public function __construct() {}

	public function make( string $name, mixed $parameters = [] ): void {
        if ( isset( $parameters[1] ) && is_array( $parameters[1] ) ) {
			echo $this->render_twig( $name, $parameters[1] );
			return;
        }

        echo $this->render_twig( $name, $parameters );
	}

	/**
	 * Renders html view using twig.
	 *
	 * @param string $location Path for the twig files.
	 * @param array  $options Array of options.
	 * @return string
	 * @throws \Twig\Error\LoaderError Throws error on load.
	 * @throws \Twig\Error\RuntimeError Throws error on runtime.
	 * @throws \Twig\Error\SyntaxError Throws error on syntax error.
	 * @throws \Twig_Error_Loader Throws error on load.
	 * @throws \Twig_Error_Runtime Throws error on runtime.
	 * @throws \Twig_Error_Syntax Throws error on syntax error.
	 */
	public function render_twig( $location, $options = array() ) {
		return $this->twig->render( $location, $options );
	}

	public function boot(): void {
		$twig = new TwigService();
		$this->twig = $twig->get();
	}
}
