<?php

return [
    /*
    |-------------------------------------------------------------
    | Your validation token from "App Credentials"
    |-------------------------------------------------------------
    */
    'token' => env('SLACK_EVENT_TOKEN', 'your-validation-token-here'),
    'slack_auth_token' => env('SLACK_AUTH_TOKEN', 'your-auth-token-here'),

    /*
    |-------------------------------------------------------------
    | Events Request URL — path, where events will be served
    |-------------------------------------------------------------
    */
    'route' => '/api/slack/event/fire',

    /*
    |-------------------------------------------------------------
    | Slack Bot user id
    |-------------------------------------------------------------
    */
    'bot_user_id' => env('SLACK_BOT_USER_ID', 'your-bot-user-id-here'),
];
