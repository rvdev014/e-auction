<?php

use chillerlan\QRCode\QRCode;

$data = 'https://youtube.com';

echo '<img width="300" height="300" src="'.(new QRCode)->render($data).'" alt="QR Code" />';
