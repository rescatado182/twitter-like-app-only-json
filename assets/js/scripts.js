function loadPosts(username)
{
    console.log(username);
    if( username !== "" ) 
    {
        $.getJSON( "vendor/services/handler.php?action=posts&username=" + username, function( data ) {
            
            var items = [];
            var responseHTML = "";

            $.each( data, function( key, val ) {

                responseHTML = `<div id="post-${key}"><div class="card-header"><div class="d-flex justify-content-between align-items-center"><div class="d-flex justify-content-between align-items-center"><div class="mr-2"><img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt=""></div><div class="ml-2"><div class="h5 m-0">${val.username}</div></div></div></div></div><div class="card-body"><div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>${val.date}</div><p class="card-text">${val.message}</p></div></div>`;
            
                items.push(responseHTML);
            });

            $( "<div/>", {
                "class": "post-card",
                html: items.join( "" )
            }).appendTo( "#posts" );
        });
    }
    else {
        alert("Username doesn't exists");
        return;
    }
}


/**
 * Get the URL parameters
 * source: https://css-tricks.com/snippets/javascript/get-url-variables/
 * @param  {String} url The URL
 * @return {Object}     The URL parameters
 */
var getParams = function (url) {
	var params = {};
	var parser = document.createElement('a');
	parser.href = url;
	var query = parser.search.substring(1);
	var vars = query.split('&');
	for (var i = 0; i < vars.length; i++) {
		var pair = vars[i].split('=');
		params[pair[0]] = decodeURIComponent(pair[1]);
	}
	return params;
};