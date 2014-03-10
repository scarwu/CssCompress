<?php
/**
 * CSS Pack
 *
 * @package     Pack
 * @author      ScarWu
 * @copyright   Copyright (c) 2012-2014, ScarWu (http://scar.simcz.tw/)
 * @link        http://github.com/scarwu/Pack
 */

namespace Pack;

class CSS
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
     * Get Packed CSS
     *
     * @return string
     */
    public function get($css = '')
    {
        if ('' === $css) {
            foreach ((array) $this->_list as $src) {
                if (!file_exists($src)) {
                    continue;
                }

                $css .= file_get_contents($src);
            }
        }

        $this->_list = [];

        return $this->pack($css);
    }

    /**
     * Save CSS to File
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
     * Pack CSS
     *
     * @param string
     * @return string
     */
    private function pack($css)
    {
        // Remove whitespace characters without space
        $css = preg_replace('/[\r\t\n\f]/', '', $css);

        // Remove Comments
        $css = preg_replace('/\/\*.+?\*\//', '', $css);

        // Replace multi-space to single space
        $css = preg_replace('/[ ]+/', ' ', $css);

        $char = [
            ',' => [' ,', ', ', ' , '],
            '{' => [' {', '{ ', ' { '],
            '}' => [' }', '} ', ' } '],
            ':' => [' :', ': ', ' : '],
            ';' => [' ;', '; ', ' ; '],
            '!' => [' !', '! ', ' ! ']
        ];

        $css = explode('"', $css);
        foreach ($css as $index => $str) {
            if (0 === $index % 2) {
                $css[$index] = trim($str);
                foreach ($char as $replace => $search) {
                    $css = str_replace($search, $replace, $css);
                }
            }
        }
        $css = implode('"', $css);

        return $css;
    }
}
