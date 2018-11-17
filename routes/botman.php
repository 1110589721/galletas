<?php
use App\Http\Controllers\BotManController;
use App\Cookie;

$botman = resolve('botman');
//abrir galleta
$botman->hears('break cookie', function ($bot) {
   $cookie = Cookie::all()->random(1)->first();


    $bot->reply($cookie->message);
});
 //crear galleta
$botman->hears('create cookies {text}', function ($bot,$text) {
   
    $cookie = new Cookie();
    $cookie -> message = $text;
    $cookie ->save();

     $bot->reply("Cookie saved!");
 });

 //actualizar galleta
 $botman->hears('update cookies {id} with {text}', function ($bot,$id,$text) {
   $cookie = Cookie::find($id);
   if($cookie ==null)
    $bot->reply("that cookie does not exist!");
    else{
        $cookie ->message = $text;
        $cookie -> save();
        $bot->reply("Cookie updated!");
    }
    
 });
 //dado un mensaje nos muestre el id
 $botman->hears('find cookies with {text}', function ($bot,$text) {
    $cookies= Cookie::where('message','LIKE',"%{$text}%")->get();
    foreach($cookies as $cookie)
    {
        $bot->reply("Cookie: ".$cookie->id);
    }
    if(count($cookies)==0)
        $bot->reply("I could not find cookies with that text");
     
  });

  //eliminar un mensaje
 $botman->hears('delete cookies {id}', function ($bot,$id) {

   $control = Cookie::where('id','=',$id)->delete();
    if($control == 0)
        $bot->reply("I could not find cookies with that id");
    else
        $bot->reply("the cookie was deleted");


    //otra forma de eliminar
//    $cookie = Cookie::find($id);
//    if($cookie == null)
//     $bot->reply("I could not find cookies with that id");
//     else{
//         $cookie->delete();
//         $bot->reply("the cookie was deleted");
//     }
  });


//$botman->hears('Hi', function ($bot) {
//    $bot->reply('Hello!');
//});
//$botman->hears('Start conversation', BotManController::class.'@startConversation');
