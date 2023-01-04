<?php
$token = 'BOT_TOKEN';
$img = "BOT_IMG";

$input = file_get_contents('php://input');
$update = json_decode($input);
$send = $update->message->text;
$chat_id = $update->message->chat->id;
$fname = $update->message->chat->first_name;
$lname = $update->message->chat->last_name;

$inlinebutton = [
    'inline_keyboard' => [
        [
            ['text' => "\xF0\x9F\x99\x8B Grubumuz", 'url' => 'https://t.me/GalaSohbet'],
            ['text' => "\xF0\x9F\x94\x94 Kanalımız", 'url' => 'https://t.me/MurtiBots']
        ],
        [
            ['text' => "\xE2\x9E\x95 Beni Gruba Ekle", 'url' => 'https://t.me/muzik_indiren_bot?startgroup=new']
        ],
    ]
];

$keyboard = json_encode($inlinebutton, true);

if (strpos($send, "/ara") === 0) {
    $ytsearch = substr($send, 5);
    $ytsearchfinal = str_replace(' ', '_', $ytsearch);
    $ytapi = file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=1&q=$ytsearchfinal&type=video&key=YT_API_KEY");
    $ytdecode = json_decode($ytapi, true);
    $id = $ytdecode['items'][0]['id']['videoId'];
    $channelname = $ytdecode['items'][0]['snippet']['channelTitle'];
    $title = $ytdecode['items'][0]['snippet']['title'];
    $publishedat = $ytdecode['items'][0]['snippet']['publishedAt'];
    $imgmp3 = $ytdecode['items'][0]['snippet']['thumbnails']['medium']['url'];

    $inlinebuttonmp3 = [
        'inline_keyboard' => [
            [
                ['text' => "\xF0\x9F\x93\xA5 İndirildi \xF0\x9F\x93\xA5", 'url' => "https://www.yt-download.org/public/api/button/mp3/$id"]
            ],
        ]
    ];

    $keyboardmp3 = json_encode($inlinebuttonmp3, true);

    $mp3text = urlencode("<b>\xF0\x9F\x93\x9D İsim - $title\n\xF0\x9F\x93\xBA Kanal - $channelname\n\xF0\x9F\x95\x9C Yayınlanma Tarihi - $publishedat\n\n\xF0\x9F\x8E\xA7 Telegram İşleyen \xF0\x9F\x8E\xA7\n~ @muzik_indiren_bot</b>");

    file_get_contents("https://api.telegram.org/bot$token/sendphoto?chat_id=$chat_id&photo=$imgmp3&parse_mode=HTML&caption=$mp3text&reply_markup=$keyboardmp3");
}

if (strpos($send, "/start") === 0) {

    $welcometext = urlencode("<b>\xF0\x9F\x8E\xA7 Müzik İndiren Bot \xF0\x9F\x8E\xA7\n\n\xF0\x9F\x91\x8B Selam $fname $lname \xF0\x9F\x92\xAD Ben Müzik İndiren Bot, Basit Bir Müzik İndirme Botuyum  \xF0\x9F\x9A\x80\n\n\xF0\x9F\x92\xAC Müzik İndirmeye Başlamam İçin /ara Komutunu Kullan\nÖrneğin - /ara Tut Elimden\n\n\xE2\x9D\x93 Yardıma İhtiyacın Olursa /yardim Komutunu Kullan \xE2\x9A\xA1\n\nDeveloper @uslanmazmurti \xf0\x9f\x87\xb1\xf0\x9f\x87\xb0</b>");

    file_get_contents("https://api.telegram.org/bot$token/sendphoto?chat_id=$chat_id&photo=$img&parse_mode=HTML&caption=$welcometext&reply_to_message_id=$msgid&reply_markup=$keyboard");
}

if (strpos($send, "/yardim") === 0) {

	$helptext = urlencode("<b>\xF0\x9F\x8E\xA7 Yardıma Mı İhtiyacın Var? \xF0\x9F\x8E\xA7\n\n\xE3\x80\xBD  Yardım İçin Sahibime Ulaş \xE3\x80\xBD\n\n\xE2\x96\xB6	@uslanmazmurti\n\xE2\x96\xB6 Bot - @muzik_indiren_bot\n\xE2\x96\xB6 Developer - @OwnerMurti\n\n\xF0\x9F\x94\xA7 Bot Komutları \xF0\x9F\x94\xA7\n\n\xE2\x96\xB6	/start - Botu Başlatır\n\xE2\x96\xB6	/yardim - Yardım Menüsü\n\xE2\x96\xB6 /ara Şarkı İsmi - Müzik İndir\nÖrneğin - /ara Tut Elimden</b>");
    
	file_get_contents("https://api.telegram.org/bot$token/sendphoto?chat_id=$chat_id&photo=$img&parse_mode=HTML&caption=$helptext&reply_to_message_id=$msgid&reply_markup=$keyboard");
}
