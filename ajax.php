<?php

/*!
 * Ajax Downloads
 * Programmer by Night Web (www.nightweb.com.br)
 */

require_once('class/Downloads.class.php');

$downloads = new Downloads;
$downloads->setUrl('https://insanydesign.us20.list-manage.com/subscribe/post?u=1910b8f04dcd0c39abf3e12be&id=d07fbe1243');

$downloads->setError(array('já está inscrito(a) na lista', 'Houve muitas tentativas de inscrição para este endereço de e-mail'));

$downloads->setDownload('https://www.dropbox.com/s/0d32da0vxpad8hl/UI%20Challenge%2010_12.fig?dl=0');

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

header("Content-type: application/json; charset=utf-8");

echo json_encode($downloads->sendForm($email), JSON_PRETTY_PRINT);