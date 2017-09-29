<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Stefan Hüsges
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

use Zend\Http\Client;

/**
 * @author Stefan Hüsges
 * @link https://github.com/tronsha/spider Project on GitHub
 */
class Http
{
    protected $client = null;

    public function __construct()
    {
        $this->client = new Client;
        $this->client->setHeaders([
            'Accept' => '*/*',
            'Accept-Charset' => 'utf-8, iso-8859-1;q=0.5, *;q=0.1',
            'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => '*',
            'Cache-Control' => 'max-age=0',
            'Connection' => 'keep-alive',
            'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:42.0) Gecko/20100101 Firefox/42.0'
        ]);
    }
}
