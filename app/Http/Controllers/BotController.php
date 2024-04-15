<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller
{
    public Request $request;
    public function webhook(Request $request){
        $update = $request->getContent(); // Récupérer le contenu de la requête
        $update = json_decode($update, true); // Décoder le contenu JSON en tableau associatif
    
        // Récupérer les informations du message
        $chat_id = $update['message']['chat']['id']; // Identifiant du chat
        $message_text = $update['message']['text']; // Contenu du message
        $username = $update['message']['from']['username']; // Nom d'utilisateur
        $first_name = $update['message']['from']['first_name']; // Prénom de l'utilisateur
    
        // Vérifier le contenu du message pour déclencher l'action appropriée
        if (strpos($message_text, 'voyage') !== false) {
            // Envoyer un message avec un clavier inline pour demander à l'utilisateur de choisir parmi les voyages
            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['text' => 'Voyage 1', 'callback_data' => 'voyage_1'],
                        ['text' => 'Voyage 2', 'callback_data' => 'voyage_2'],
                    ],
                ]
            ];
    
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => "Bonjour $first_name, veuillez choisir parmi les voyages suivants :",
                'reply_markup' => json_encode($keyboard)
            ]);
        } elseif (strpos($message_text, 'ok') !== false) {
            // Traiter le choix de l'utilisateur et envoyer un récapitulatif
            // ... (logique pour générer le récapitulatif en fonction du choix de l'utilisateur)
            // Envoi du récapitulatif
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => "Récapitulatif du voyage sélectionné : ... (informations du voyage)"
            ]);
        } else {
            // Répondre au message initial
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => "Bonjour $first_name, vous avez dit : $message_text"
            ]);
        }
    }
    
    

    public function show(){
        return json_encode($this->request);
    }
}