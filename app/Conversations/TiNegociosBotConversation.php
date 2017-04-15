<?php

namespace App\Conversations;

use Mpociot\BotMan\Answer;
use Mpociot\BotMan\Button;
use Mpociot\BotMan\Conversation;
use Mpociot\BotMan\Question;

class TiNegociosBotConversation extends Conversation
{
    public function askOption()
    {
        $firstName = $this->bot->getUser()->getFirstName();
        $question = Question::create('Como posso te ajudar, ' . $firstName . '?')
            ->fallback('Não foi possível perguntar a opção.')
            ->callbackId('ask_option')
            ->addButtons([
                Button::create('TOKEN')->value('token'),
                Button::create('FGTS')->value('fgts'),
                Button::create('CONTAS INATIVAS')->value('contas inativas'),
                
                Button::create('GIT Universidade.CAIXA')->value('git universidade caixa'),
                Button::create('Google Drive do grupo')->value('google drive'),
                Button::create('GitLab do grupo')->value('gitlab'),
                
                Button::create('...')->value('...'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                switch ($answer->getValue()) {
                    case 'token':
                        $token = md5(rand());
                        $this->bot->typesAndWaits(2);
                        $this->say('Oi, ' . $this->bot->getUser()->getFirstName() . ', aqui vai seu token: ' . "\n" . $token);
                        $this->askOption();
                        break;
                    case 'fgts':
                        $this->bot->typesAndWaits(2);
                        $this->say('O FGTS é um benefício que ajuda o trabalhador a formar um patrimônio e a comprar a casa própria, saiba mais em http://www.caixa.gov.br/beneficios-trabalhador/fgts/Paginas/default.aspx');
                        $this->askOption();
                        break;
                    case 'contas inativas':
                        $this->bot->typesAndWaits(2);
                        $this->say('Veja suas contas inativas e saiba como sacá-las em https://www.contasinativas.caixa.gov.br/pages/inter/home.html');
                        $this->askOption();
                        break;
                    
                    case 'git universidade caixa':
                        $this->say('O Git da Universidade Caixa é esse aqui: ' . env('TINEGOCIOS_GIT_UNIVERSIDADE_CAIXA') . '. Ainda não tem acesso? Fale com: ' . env('TINEGOCIOS_PEDIDO_ACESSOS'));
                        $this->askOption();
                        break;
                    case 'google drive':
                        $this->say('O Google Drive que estamos usando é esse aqui: ' . env('TINEGOCIOS_GOOGLE_DRIVE') . '. Ainda não tem acesso? Fale com: ' . env('TINEGOCIOS_PEDIDO_ACESSOS'));
                        $this->askOption();
                        break;
                    case 'gitlab':
                        $this->say('O GitLab que estamos usando é esse aqui: ' . env('TINEGOCIOS_GITLAB') . '. Ainda não tem acesso? Fale com: ' . env('TINEGOCIOS_PEDIDO_ACESSOS'));
                        $this->askOption();
                        break;

                    default:
                        $this->say('Nenhuma opção? Tranquilo. Eu estou por aqui, se quiser é só me chamar novamente.');
                        break;
                }
            }
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askOption();
    }

}