<?php

namespace Bundle\Everzet\JadeBundle\Renderer;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Templating\Storage\Storage;
use Symfony\Component\Templating\Storage\FileStorage;

use Everzet\Jade\Jade;

/*
* This file is part of the EverzetJadeBundle.
* (c) 2010 Konstantin Kudryashov <ever.zet@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

/**
 * Jade Renderer. 
 */
class Renderer
{
    protected $jade;

    /**
     * Initialize Jade Renderer. 
     * 
     * @param   Jade    $jade   jade renderer
     */
    public function __construct(Jade $jade)
    {
        $this->jade = $jade;
    }

    /**
     * Evaluates a template.
     *
     * @param Storage $template   The template to render
     * @param array   $parameters An array of parameters to pass to the template
     *
     * @return string|false The evaluated template, or false if the renderer is unable to render the template
     */
    public function evaluate(Storage $template, array $parameters = array())
    {
        $storage = new FileStorage($this->jade->cache($template));

        $__template__ = $storage;
        if ($__template__ instanceof FileStorage) {
            extract($parameters);
            $view = $this->engine;
            ob_start();
            require $__template__;
            return ob_get_clean();
        } elseif ($__template__ instanceof StringStorage) {
            extract($parameters);
            $view = $this->engine;
            ob_start();
            eval('; ?>'.$__template__.'<?php ;');
            return ob_get_clean();
        }
        return false;
    }

    /**
     * Sets the template engine associated with this renderer.
     *
     * @param Engine $engine A Engine instance
     */
    public function setEngine($engine)
    {
    	$this->engine = $engine;
    }
}
