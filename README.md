# tuto-botman-laravel-starter

Para fazer o tutorial, o Bot criado foi apenas no Telegram: é o [@TiNegociosBot](https://t.me/TiNegociosBot). No entanto, a biblioteca [BotMan](https://botman.io/) permite usar o mesmo código para criar a estrutura de Bots para [várias plataformas](https://botman.io/1.5/configuration).

## Lista de arquivos efetivamente alterados

- [routes/botman](routes/botman.php)
- [BotManController](app/Http/Controllers/BotManController.php)
- [TiNegociosBotConversation](app/Conversations/TiNegociosBotConversation.php)

## Requisitos

- Conta no Telegram
- Ambiente PHP com os requisitos do boilerplate <https://packagist.org/packages/mpociot/botman-laravel-starter>
- Alguma forma de servir sua aplicação local em uma URL pública (tem várias opções: seja via [Laravel Valet](https://laravel.com/docs/5.4/valet), [Vagrant Share](https://www.vagrantup.com/docs/share/) ou [Ngrok](https://ngrok.com/)).
- Git opcional

## Como usar

### Registrar Bot

Primeiro, é necessário criar o Bot lá no Telegram (mais info aqui: https://core.telegram.org/bots/api):

1. /newbot
1. Nome do seu bot <Enter> (qualquer nome Bot)
1. Username do seu bot <Enter> (QualquerNomeBot)

Depois de completar os passos acima, você recebe um ACCESS TOKEN, parecido com esse aqui: ` 123456789:Adfkj9jjdf9j9jdf9jRkjerkjMijijJUd11`. Copie seu ACCESS TOKEN, pois ele será usado mais na frente.

### Aplicação

Agora, é hora de mexer na aplicação:

1. Baixe o projeto (ou via `git clone https://github.com/rogeriopradoj/tuto-botman-laravel-starter`, ou [download do zip](https://github.com/rogeriopradoj/tuto-botman-laravel-starter/archive/master.zip)).

2. Edite o arquivo .env` para [conectar com Telegram](https://github.com/mpociot/botman#connect-with-your-messaging-service) (é aqui que você vai usar aquele ACCESS TOKEN lá em cima).

3. Edite as configurações *TINEGOCIOS_* também no arquivo `.env`.

4. Depois disso é só rodar o servidor web e servir a aplicação numa url pública (o jeito mais fácil na minha máquina foi rodando `valet link` e depois `valet share`). No meu caso, a URL ficou parecida com essa daqui: <https://a1234567.ngrok.io/>

Se você tentar acesar a URL no seu navegador, deve aparecer uma página de erro `NotFoundHttpException in RouteCollection.php line 161:`. Se isso acontecer esta tudo certo. É porque a rota que vamos usar não é a rota raiz, e sim a rota `/botman/`.

### Registrando a url da aplicação no Bot

Por fim, é necessário cadastrar a URL do webhook de seu Bot, conforme [instruções do Telegram](https://core.telegram.org/bots/api#setwebhook).

Você tem várias formas de fazer isso, a mais fácil:

- pegue seu ACCESS TOKEN do Bot (exemplo: `123456789:Adfkj9jjdf9j9jdf9jRkjerkjMijijJUd11`)
- pegue a sua URL pública da aplicação com a rota `/botman/` (exemplo: <https://a1234567.ngrok.io/botman/>)
- ajuste na "URL final" `https://api.telegram.org/bot<ACCESS TOKEN>/setWebhook?url=<URL PÚBLICA DA APLICAÇÃO>/botman/` (exemplo: <https://api.telegram.org/bot123456789:Adfkj9jjdf9j9jdf9jRkjerkjMijijJUd11/setWebhook?url=https://a1234567.ngrok.io/botman/>)

Pronto, agora, acesse essa URL final no seu navegador mesmo, você deve receber a seguinte resposta que está tudo ok:

```json
{"ok":true,"result":true,"description":"Webhook was set"}
```

### Colocando a aplicação em um hosting real PaaS

A plataforma que usei foi [Google Cloud App Engine Flexible Environment](https://cloud.google.com/appengine/) seguindo [as orientações daqui](https://cloud.google.com/community/tutorials/run-laravel-on-appengine-flexible) (outra opção seria via [Heroku](http://www.easylaravelbook.com/blog/2015/01/31/deploying-a-laravel-application-to-heroku/)).

Aproveitei também para usar o [Docker](https://www.docker.com/) para rodar os comandos Google Cloud SDK em vez de fazer a instalação na minha própria máquina.

Seguem passos:

1. Criar o projeto Google Cloud em <https://console.cloud.google.com>.

2. Habilitar o Billing no projeto em <https://console.cloud.google.com/billing>.

3. Baixar a imagem Docker do SDK: `docker pull google/cloud-sdk`

4. Inicializar o ambiente do SDK na minha máquina e vinculei com o projeto Google Cloud: `docker run -t -i --name gcloud-config google/cloud-sdk gcloud init`

5. Fazer o deploy da aplicação: `docker run --rm -ti -v `pwd`:/apps -w="/apps" --volumes-from gcloud-config google/cloud-sdk gcloud app deploy`

6. Registrar a URL do projeto gerada pelo Google Cloud no [Telegram](https://core.telegram.org/bots/api#setwebhook):`https://api.telegram.org/bot<ACCESS TOKEN>/setWebhook?url=<URL DO PROJETO>/botman/` (exemplo: <https://api.telegram.org/bot123456789:Adfkj9jjdf9j9jdf9jRkjerkjMijijJUd11/setWebhook?url=https://url-do-projeto.appspot.com/botman/>).

## Próximas fases

Colocar NLP (natural language processing): https://rasa.ai/, https://wit.ai/, https://api.ai/, https://www.luis.ai/, https://www.ibm.com/watson/ etc.

## Fontes
- <http://christoph-rumpel.com/2017/03/Build-A-Telegram-Group-Bot/>
- <http://christoph-rumpel.com/2017/01/Setup-a-messenger-chatbot-in-laravel/>
- <https://chatbotslife.com/how-to-build-facebook-messenger-chatbot-in-php-with-structured-messages-59fb4e839f3c>
- <https://t.me/tinegociosbot>