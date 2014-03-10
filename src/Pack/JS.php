<?php
/**
 * JavaScript Pack
 *
 * @package     Pack
 * @author      ScarWu
 * @copyright   Copyright (c) 2012-2014, ScarWu (http://scar.simcz.tw/)
 * @link        http://github.com/scarwu/Pack
 */

namespace Pack;

class JS
{
    /**
     * @var array
     */
    private $_list;

    /**
     * @param array
     * @param string
     */
    public function __construct()
    {
        $this->_list = [];
    }

    /**
     * Append Path or List to List
     *
     * @param string
     * @return object
     */
    public function append($list = null)
    {
        if (is_string($list)) {
            $this->_list[] = $list;
        }

        if (is_array($list)) {
            $this->_list = array_merge($this->_list, $list);
        }

        return $this;
    }

    /**
     * Get Packed JavaScript
     *
     * @return string
     */
    public function get($js = '')
    {
        if ('' === $js) {
            foreach ((array) $this->_list as $src) {
                if (!file_exists($src)) {
                    continue;
                }

                $js .= file_get_contents($src);
            }
        }

        $this->_list = [];

        return $this->pack($js);
    }

    /**
     * Save JavaScript to File
     *
     * @param string
     */
    public function save($dest = null)
    {
        if (!file_exists(dirname($dest))) {
            mkdir(dirname($dest), 0755, true);
        }

        file_put_contents($dest, $this->get());
    }

    /**
     * Pack JavaScript
     *
     * @param string
     * @return string
     */
    private function pack($js)
    {
        // Remove Single-line comment

        // Remove Mutli-line Comment

        //
        return $js;
    }
}