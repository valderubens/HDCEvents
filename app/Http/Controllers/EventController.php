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

        //Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            // Armazena nome da imagem nessa var
            $requestImage = $request->image;

            // Armazena a extensão da imagem nessa var
            $extension = $requestImage->extension();

            // Cria nome único para ser o path armazenado no Banco de Dados através de método md5 composto por nome da imagem + hora + extensão (PROCURAR O QUE É md5). O arquivo de fato é armazenado no servidor
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now") . "." . $extension);

            // Adicionar a imagem à pasta
            $requestImage->move(public_path('img/events'), $imageName);

            // Alteração de var (???)
            $event->image = $imageName;

        };

        //Salva dados enviados via método POST
        $event->save();

        //Redireciona para a página inicial (redirect)
        //Flash message (with)
        return redirect('/')->with('msg', 'Evento criado com sucesso');


    }

    // Recebe $id como parâmetro (origem no front-end)
    public function show($id) {

        $event = Event::findOrFail($id);

        // Retorna a view com os dados
        return view('events.show', ['event' => $event]);

    }

}


