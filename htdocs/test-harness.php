<html>
    <head>
        <title>API - Test Harness</title>
        
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script>
            var json;
            $(document).ready(function(){
                $('form').submit(function(){
                    $('p.request').text($('input[name=url]').val());
                    $.ajaxSetup({
                        url: $('input[name=url]').val(),
                        dataType: 'json',
                        type: $('input:radio[name=method]:checked').val()
                    });
                    $.ajax({
			beforeSend: function(xhr) {
			    xhr.setRequestHeader('OnsideAuth', '01a2e0d73218f42d1495c3670b79f1bd44d7afa316340679bcd365468b736482');
			},
                        dataType: 'json',
                        data: $('textarea[name=payload]').val(),
                        dataFilter: function(data, type){
                            json = data;
                            $('p.response').text(data);
                            return data;
                        },
                        success: function(data){
                            //json = data;
                            //$('textarea[name=response]').val(data.toString());
                        }
                    });
                    return false;
                });
            });
        </script>
    </head>
    <body>
        <h2>API - Test Harness</h2>
        <form>
            <label for="method">Method: </label>
            <input type="radio" name="method" value="GET" checked="checked" /> - get
            <input type="radio" name="method" value="POST" /> - post
            <input type="radio" name="method" value="DELETE" /> - delete
            <input type="radio" name="method" value="PUT" /> - put
            
            <button>Send Request</button>
            
            <br />
            
            <label for="service">API Call: </label>
            <select name="service">
                <option value="article">Article</option>
                <option value="channel">Channel</option>
                <option value="discussion">Discussion</option>
                <option value="event">Event</option>
                <option value="user">User</option>
            </select>
            
            <label for="url">Url</label>
            <input type="text" name="url" value="" />
            
            <br />
            <!-- fluid variables //-->
            
        </form>
        
        
        <!-- results //-->
        <p class="request"></p>
        <br />
        <textarea name="payload" rows="10" cols="65"></textarea>
        <br />
        <p class="response"></p>
        
    </body>
</html>