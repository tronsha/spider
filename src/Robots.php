<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 - 2018 Stefan Hüsges
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Spider;

/**
 * @author Stefan Hüsges
 * @link https://github.com/tronsha/spider Project on GitHub
 * @link http://www.robotstxt.org/ The Web Robots Pages
 * @link https://en.wikipedia.org/wiki/Robots_exclusion_standard Wikipedia - Robots exclusion standard
 */
class Robots
{
    private $robots = [];

    /**
     * Robots constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $domain
     *
     * @return string
     */
    public function getFile($domain)
    {
        if (true === isset($this->robots[$domain])) {
            return $this->robots[$domain];
        }

        $client = new Client();
        $client->setUrl($domain . '/robots.txt');
        try {
            $client->request();
            if (200 === (int)$client->getStatusCode()) {
                return $this->robots[$domain] = $client->getContent();
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
