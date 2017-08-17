<html>
  <head>
    <style>
      .box{
        width: 100px;
        height: 100px;
        border: solid 2px #131313;
        display: inline-block;
        margin: auto 2px;
      }
    </style>
  </head>
  <body>
    <div id="inputArea">
      <p>
        Instructions: <br/>
        In the text area below enter the text you want to occupy each bingo space. <br/>
        A new line represents a new bingo space. <br/>
        Bingo boards are a square 'size' represents both width and height. So size 5 would result in a 5 x 5 bingo board.
        To generate bingo boards that contain only some of the possible spaces, specify more space options than sizexsize.
      </p>
      <p style="display:none;">
        Example input: <br/>
        size: 3 <br/>
        text area: <br/>
        A<br/>B</br>C<br/>D<br/>E<br/>F<br/>G<br/>H<br/>
      </p>
      <textarea id="list" rows="25" cols="100"></textarea>
      <br/>
      <input type="text" placeholder="size" id="size"/>
      <br/>
      <button onclick="generateCard()">Generate Card</button>
    </div>
    <div id="resultArea">

    </div>
    <script>
      function getConfigs(url){
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", url, false);
        xhttp.send(null);
        return xhttp.responseText;
      }

      var config = getConfigs("./config.json");
      config = JSON.parse(config);

      function generateCard(){
        var size = document.getElementById("size").value;
        var list = document.getElementById("list").value;
        //TODO: handling to check if empty
        randomize(size, list);
      }

      function randomize(size, list){
        var json = formatinputs(size, list);
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", config.randomizer);
        xhttp.onreadystatechange = function(){
          if (xhttp.readyState>3 && xhttp.status==200) { cardify(xhttp.responseText); }
        };
        xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhttp.send(JSON.stringify(json));
      }

      function formatinputs(size, list){
        var arrayList = list.split( "\n" );

        var payload = {
          payload: {
            size: size,
            spaces: arrayList
          }
        };
        return payload;
      }

      function cardify(result){
        var payload = {payload: JSON.parse(result)};
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", config.card);
        xhttp.onreadystatechange = function(){
          if (xhttp.readyState>3 && xhttp.status==200) { addToDom(xhttp.responseText); }
        };
        xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhttp.send(JSON.stringify(payload));
      }

      function addToDom(result){
        document.getElementById("resultArea").innerHTML = JSON.parse(result).body;
      }

    </script>
  </body>
</html>
