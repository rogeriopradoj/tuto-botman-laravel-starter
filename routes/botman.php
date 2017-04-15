<?php
use App\Http\Controllers\BotManController;

// Don't use the Facade in here to support the RTM API too :)
$botman = resolve('botman');


$botman->hears('/start', BotManController::class.'@startConversation');

$botman->hears('/help', function($bot){
    $bot->typesAndWaits(2);
    $bot->reply('Como vai, ' . $bot->getUser()->getFirstName() . ', tudo bem? Eu sou o TI Negócios Bot e estou aqui para te ajudar. Para falar comigo é só digitar /start.');
});

$botman->fallback(function($bot) {
    $bot->typesAndWaits(1);
    $bot->reply('Digite /start para começar ou /help para saber mais sobre o bot.');
});
