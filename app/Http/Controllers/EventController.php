<?php

/*
    Os controllers do laravel condensam a maior parte da lógica
    Cumprem o papel de enviar e esperar respostas do banco de dados
    Também enviam e rebem respostas das views
    Controllers podem ser criados via terminal através do artisan
    Funções comuns: retornar uma view ou redirecionar o usuário para um URL específica

    Cada controle tem uma série de métodos, chamados actions
        - adicionar produto, resgatar produto, alterar produto, ...
    Dentro da action fica o código que representa uma view
        - usuário acessa uma rota -> action de um controller -> retorna uma view
    A modelação do Banco de Dados ocorre assim:
        - identificação da url acessada pelo arquivo de rotas
        - execução da lógica necessária no controller
            - entrar no Banco de Dados
            - resgatar/adicionar a informação
            - retornar p/ view o que foi solicitado
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

class EventController extends Controller
{
    public function index() {   //index action ou rota principal

        $events = Event::all();
    
        return view('welcome', ['events' => $events]);
    }

    public function create() {
        return view('events.create');
    }

    // Todos os dados do formulário virão por meio desse request
    public function store(Request $request) {

        $event = new Event;

        $event->title = $request->title;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;

        //Salva dados enviados via método POST
        $event->save();

        //Redireciona para a página inicial (redirect)
        //Flash message (with)
        return redirect('/')->with('msg', 'Evento criado com sucesso');


    }

}


