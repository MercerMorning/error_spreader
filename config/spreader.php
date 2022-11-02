<?php
return [
  'telegram' => [
      'bot' => [
          'token' => env('TELEGRAM_BOT_TOKEN')
      ],
      'chat' => [
          'id' => env('TELEGRAM_CHAT_ID')
      ]
  ]
];
