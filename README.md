## Relation to openwhisk
This small example demonstrates how to off-load computation leveraging openwhisk's PHP runtime.  
The greatest takeaways are how to use $args and the format of how to return values and use them in your website.  

## Getting all this working using openwhisk   
### Using the wsk cli  
These instructions assume you have a localhost apache server with PHP interpreting config ON
These instructions assume you have an instance of openwhisk running on your machine and the CLI installed.  
These instructions also assume you have gotten username:password, host, namespace, and apigtoken from your ~/.wskprops.  
 * `wsk -i action create randomizer phpRandomizerAction.php --web true`  
 * `wsk -i action create card bingocard.php --web true`  
 * `wsk -i api create /bingo/random post /<namespace>/randomizer`
 * COPY the URL that comes back from that command. That is how you'll access the randomizer endpoint.
 * `wsk -i api create /bingo/card post /<namespace>/card --response-type http`
 * COPY the URL that comes back from that command. This is how you'll access the card endpoint.
 * Create a new file called `config.json` under your working directory (/randomize-bingo-card/config.json)
 * Add the URLs to it in the form:
 ```
 {
   "randomizer": "</bingo/random api url>",
   "card": "</bingo/card api url>"
 }
 ```

 Access index.php
 ex: `http://localhost/~<myuser>/randomize-bingo-card/`


## Mock post request
 Call the randomizer to create the JSON for a bingo card:
 The randomizer can be turned into an openwhisk action.
 `curl -X POST -d '{"payload":{"size":5,"spaces":["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X"]}}' http://localhost/~<myuser>/randomize-bingo-card/phpRandomizerAction.php`

 Call the bingocard to create the markup:
 `curl -X POST -d '{"payload":{"size":5,"bingocard":["A","B","C","D","E","F","G","H","I","J","K","L","FREE SPOT","M","N","O","P","Q","R","S","T","U","V","W","X"]}}' http://localhost/~<myuser>/randomize-bingo-card/bingocard.php`

 Alternatively, replace the URLs with the URLs returned from the create api openwhisk call.
