php-twientbot
==============

php-twientbot is a twitter client bot.

Setup for Heroku
============

### Setup project directory

Download from [Github](https://github.com/makotokw/php-twientbot/archive/master.zip) and commit all files to **YOUR** Git repository.

```
$ git init
$ git add .
$ git commit -m "first commit"
```

Prepare ``data/{screen_name#lowercase}.txt`` and commit it. (if twitter screen name is ``ScreenName``, filename should be ``screenname.txt`` )

```
$ git add data/*.txt
$ git commit -m "added data file"
```

### Create heroku application

```
$ heroku create your_app
$ heroku config:set BUILDPACK_URL=https://github.com/CHH/heroku-buildpack-php
$ git push heroku master
```

### Register twitter application

[https://apps.twitter.com](https://apps.twitter.com)

 * ``Callback URL`` is **NOT** required for the Bot application.
 * Set ``Read and Write`` as permissions
 * Copy ``API key`` and ``API secret`` on API Keys tab

Set ``API key`` and ``API secret`` to config.

```
heroku config:set APP_CONSUMER_KEY=xxxxxxxx
heroku config:set APP_CONSUMER_SECRET=xxxxxxxx
```

### Set OAuth user token

Execute ``php extras/oauth.php`` by heroku.

```
$ heroku run php extras/oauth.php
Running `php extras/oauth.php` attached to terminal... up, run.1234
Go to https://api.twitter.com/oauth/authorize?oauth_token=xxxxx
Input PIN: 
```

Launch the url (https://api.twitter.com//authorize?oauth_token...) by browser and sign in twitter account to post for bot. Then input the number of about 7 digits are displayed.

```
Input PIN: 1234567
Your token is "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
Your secret token is "yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy"
```

Set user tokens to config. (if twitter screen name is ``screen_name``, keys should be ``SCREEN_NAME_TOKEN`` and ``SCREEN_NAME_SECRET`` )

```
heroku config:set {screen_name#uppercase}_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
heroku config:set {screen_name#uppercase}_SECRET=yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy
```

### Add Heroku Add-on

```
$ heroku addons:add rediscloud
$ heroku addons:add scheduler
```

### Tweet manually

```
heroku run php bot.php post [bot_account]
```


### Tweet by scheduler

```
$ heroku addons:open scheduler
```

Add **Hourly** Job.

ex) Task:
``php bot.php post [bot_account] --executed-at=11,13,15,17 --timezone=Asia/Tokyo``

|arg|desciption|
|:--|:--|
|bot_account|Bot ScreenName|
|--executed-at|Hours to post|
|--timezone|[PHP Timezone](http://www.php.net/manual/en/timezones.php) for ``--executed-at``|

You can manage multiple twitter accounts.


LICENSE
=========

The MIT License (MIT)  
See also LICENSE file