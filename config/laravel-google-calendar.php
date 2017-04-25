<?php

return [

    /**
     * Path to a json file containing the credentials of a Google Service account.
     */
    // development
    'client_secret_json' => storage_path('app/laravel-google-calendar/montserrat-dev-cb9265e52c2f.json'),
    // production
    //'client_secret_json' => storage_path('app/laravel-google-calendar/montserrat-polanco-4debe428bb97.json'),

    /**
     *  The id of the Google Calendar that will be used by default.
     */
    //production
    //'calendar_id' => 'montserratretreat.org_6rll8gg5fu0tmps7riubl0g0cc@group.calendar.google.com',
    //development
    
    'calendar_id' => 'montserratretreat.org_fs5il4q8ofjgpfmij2tnht1ito@group.calendar.google.com',
    
];
