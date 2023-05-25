@extends('layouts.page')

@section('title')
<title>Open source licenses</title>
@endsection

@section('main')
    <div class="container">
        <h1 class="mt-5">Open source licenses</h1>
        <p class="lead">PHP version {{ PHP_VERSION }}</p>
        <p class="text-wrap">--------------------------------------------------------------------<br>
            The PHP License, version 3.01<br>
Copyright (c) 1999 - 2023 The PHP Group. All rights reserved.<br>
--------------------------------------------------------------------<br>
<br>
Redistribution and use in source and binary forms, with or without
modification, is permitted provided that the following conditions
are met:<br>
<br>
1. Redistributions of source code must retain the above copyright
notice, this list of conditions and the following disclaimer.<br>
<br>
2. Redistributions in binary form must reproduce the above copyright
notice, this list of conditions and the following disclaimer in
the documentation and/or other materials provided with the
distribution.<br>
<br>
3. The name "PHP" must not be used to endorse or promote products
derived from this software without prior written permission. For
written permission, please contact group@php.net.<br>
<br>
4. Products derived from this software may not be called "PHP", nor
may "PHP" appear in their name, without prior written permission
from group@php.net.  You may indicate that your software works in
conjunction with PHP by saying "Foo for PHP" instead of calling
it "PHP Foo" or "phpfoo"<br>
<br>
5. The PHP Group may publish revised and/or new versions of the
license from time to time. Each version will be given a
distinguishing version number.<br>
Once covered code has been published under a particular version
of the license, you may always continue to use it under the terms
of that version. You may also choose to use such covered code
under the terms of any subsequent version of the license
published by the PHP Group. No one other than the PHP Group has
the right to modify the terms applicable to covered code created
under this License.<br>
<br>
6. Redistributions of any form whatsoever must retain the following
acknowledgment:
"This product includes PHP software, freely available from
&lt;http://www.php.net/software/>". <br>
<br>
THIS SOFTWARE IS PROVIDED BY THE PHP DEVELOPMENT TEAM ``AS IS'' AND
ANY EXPRESSED OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE PHP
DEVELOPMENT TEAM OR ITS CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
OF THE POSSIBILITY OF SUCH DAMAGE.<br>
<br>
--------------------------------------------------------------------<br>
<br>
This software consists of voluntary contributions made by many
individuals on behalf of the PHP Group.<br>
<br>
The PHP Group can be contacted via Email at group@php.net.<br>
<br>
For more information on the PHP Group and the PHP project,
please see &lt;http://www.php.net>.<br>
<br>
PHP includes the Zend Engine, freely available at
&lt;http://www.zend.com>.<br></p>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://www.php.net/">PHP website</a>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://github.com/php/php-src/blob/master/LICENSE">PHP License</a>
        <p class="lead">Laravel version {{ Illuminate\Foundation\Application::VERSION }}</p>
        <p>The Laravel framework is open-sourced software licensed under the MIT license.</p>
<p class="text-wrap">Begin license text.<br>
    <br>
Copyright &lt;YEAR> &lt;COPYRIGHT HOLDER><br>
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the “Software”), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br>
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br>
THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.<br>
<br>
End license text.<br></p>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://laravel.com/">Laravel website</a>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://opensource.org/licenses/MIT">MIT License</a>
        <p class="lead">Bootstrap version 5.3.0 </p>
        <p>Bootstrap is released under the MIT license and is copyright 2023.</p>
<p class="text-wrap">Begin license text.<br>
    <br>
Copyright &lt;YEAR> &lt;COPYRIGHT HOLDER><br>
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the “Software”), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br>
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br>
THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.<br>
<br>
End license text.<br></p>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://getbootstrap.com">Bootstrap website</a>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://getbootstrap.com/docs/5.3/about/license/">Bootstrap License</a>
        <p class="lead">Vectors and icons by SVG Repo.</p>
        <p>"Weather Moon SVG Vector" and "Home 1 SVG Vector" were licensed under CC Attribution License.</p>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://www.svgrepo.com">SVG Repo website</a>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://www.svgrepo.com/page/licensing#CC%20Attribution">SVG Repo License</a>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://www.svgrepo.com/svg/381328/weather-moon">Weather Moon SVG Vector</a>
        <a class="btn btn-success mt-1 mb-1 me-2" href="https://www.svgrepo.com/svg/488999/home-1">Home 1 SVG Vector</a>
    </div>
@endsection

