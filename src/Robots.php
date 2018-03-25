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
    private $disallow = [];

    /**
     * Robots constructor.
     */
    public function __construct()
    {
    }
    
    public function isDisallow($url)
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);
        $host = parse_url($url, PHP_URL_HOST);
        $port = parse_url($url, PHP_URL_PORT);
        $path = parse_url($url, PHP_URL_PATH);
        $domain = $scheme . '://' . $host . (false === empty($port) ? ':' . $port : '');
        $domainKey = md5($domain);
        $disallows = [];
        if (false === isset($this->robots[$domain])) {
            $disallows = $this->getDisallow($domain);
        } else {
            $disallows = $this->disallow[$domainKey];
        }
        $url .= null === $path ? '/' : '';
        foreach ($disallows as $disallow) {
            if (false !== strpos($url, $disallow)) {
                return true;
            }
        }
        return false;
    }
    
    public function getDisallow($domain)
    {
        $domainKey = md5($domain);
        $file = $this->getRobotsTxtFile($domain);
        $fileWithoutComments = preg_replace('/#.*\n/', '', $file);
        $fileWithoutCommentsAndBlanklines = preg_replace('/[\r\n]+/', "\n", $fileWithoutComments);
        $fileArray = explode("\n", $fileWithoutCommentsAndBlanklines);
        $enableGetDisallow = false;
        foreach ($fileArray as $line) {
            if ($line === 'User-agent: *') {
                $enableGetDisallow = true;
                continue;
            }
            if ($enableGetDisallow) {
                if (false !== strpos($line, 'Disallow:')) {
                    $path = trim(str_replace('Disallow:', '', $line));
                    if (false === empty($path)) {
                        $this->disallow[$domainKey][] = $domain . $path;
                    }
                } else {
                    break;
                }
            }
        }
        return $this->disallow[$domainKey] ?? [];
    }

    /**
     * @param string $domain
     *
     * @return string
     */
    public function getRobotsTxtFile($domain)
    {
        if (true === isset($this->robots[$domain])) {
            return $this->robots[$domain];
        }

        $client = new Client();
        $client->setUrl($domain . '/robots.txt');
        try {
            $client->request();
            if (200 === $client->getStatus()) {
                return $this->robots[$domain] = $client->getContent();
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
