<?php

$qrCode = Endroid\QrCode\QrCode::create('test');
$writer = new Endroid\QrCode\Writer\PngWriter();
$result = $writer->write($qrCode);

header('Content-Type: ' . $result->getMimeType());
$result->getString();
