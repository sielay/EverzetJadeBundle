<?php

/*
 * Based on (c) 2012 Justin Hileman https://raw.githubusercontent.com/bobthecow/BobthecowMustacheBundle/master/MustacheEngine.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bundle\Everzet\JadeBundle;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Templating\Storage\FileStorage;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\TemplateReference;

/**
 * This engine knows how to render Jade templates.
 */
class Engine implements EngineInterface
{
    protected $jade;
    protected $parser;
    protected $loader;

    /**
     * Constructor.
     *
     * @param Jade             $jade A \Jade instance
     * @param TemplateNameParserInterface $parser   A TemplateNameParserInterface instance
     */
    public function __construct(Jade $jade, TemplateNameParserInterface $parser, $loader)
    {
        $this->jade = $jade;
        $this->parser   = $parser;
        $this->loader = $loader;
    }

    /**
     * Renders a template.
     *
     * @param mixed $name       A template name
     * @param array $parameters An array of parameters to pass to the template
     *
     * @return string The evaluated template as a string
     *
     * @throws \InvalidArgumentException if the template does not exist
     * @throws \RuntimeException         if the template cannot be rendered
     */
    public function render($name, array $parameters = array())
    {
        
        $rendered = $this->jade->render($this->nameToStorage($name));
        var_dump($rendered);
        return $rendered;
    }
    
    private function nameToStorage($name)
    {
        $template = $this->parser->parse($name);
        var_dump($template);
        $loaded = $this->loader->load($template);
        return $loaded;
    }

    /**
     * Returns true if the template exists.
     *
     * @param mixed $name A template name
     *
     * @return Boolean true if the template exists, false otherwise
     */
    public function exists($name)
    {
        try {
            $this->nameToStorage($name);
        } catch (\InvalidArgumentException $e) {
            var_dump($e);
            return false;
        }

        return true;
    }

    /**
     * Returns true if this class is able to render the given template.
     *
     * @param string $name A template name
     *
     * @return Boolean True if this class supports the given resource, false otherwise
     */
    public function supports($name)
    {
        /*if ($name instanceof \Mustache_Template) {
            return true;
        }*/

        $template = $this->parser->parse($name);

        return 'jade' === $template->get('engine');
    }

    /**
     * Renders a view and returns a Response.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A Response instance
     *
     * @return Response A Response instance
     */
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        if (null === $response) {
            $response = new Response();
        }

        $response->setContent($this->render($view, $parameters));

        return $response;
    }
}