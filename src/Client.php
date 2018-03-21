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

use GuzzleHttp\Client as Guzzel;

/**
 * @author Stefan Hüsges
 * @link https://github.com/tronsha/spider Project on GitHub
 */
class Client
{
    private $client = null;
    private $response = null;
    private $requestHeader = [];
    private $url = '';

    /**
     *
     */
    public function __construct()
    {
        $this->client = new Guzzel;
        $this->setHeader('Accept', '*/*');
        $this->setHeader('Accept-Charset', 'utf-8, iso-8859-1;q=0.5, *;q=0.1');
        $this->setHeader('Accept-Encoding', 'gzip, deflate');
        $this->setHeader('Accept-Language', '*');
        $this->setHeader('Cache-Control', 'max-age=0');
        $this->setHeader('Connection', 'keep-alive');
        $this->setHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0');
    }
    
    /**
     * @param string $key
     * @return string
     */
    private function prepareKey(string $key): string
    {
        $parts = explode('-', strtolower($key));
        foreach ($parts as &$part) {
            $part = ucfirst($part);
        }
        return implode('-', $parts);
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function setHeader(string $key, string $value)
    {
        $this->requestHeader[$this->prepareKey($key)] = $value;
    }
    
    /**
     * @param string|null $key
     * @return string|array
     */
    public function getHeader($key = null)
    {
        if (null !== $key) {
            return $this->requestHeader[$this->prepareKey($key)] ?? null;
        }
        return $this->requestHeader;
    }

    public function request()
    {
        $this->response = $this->client->request('GET', $this->getUrl(), $this->getHeader());
    }
   
    /**
     * @return string
     */
    private function getUrl(): string
    {
        return $this->url;
    }
    
    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return (int) $this->response->getStatusCode();
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->response->getBody()->getContents();
    }
}
