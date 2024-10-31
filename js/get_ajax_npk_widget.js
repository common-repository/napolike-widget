jQuery(document).ready(function(){
	try{
	// Prendo l'elenco di categorie per trovare l'id
	res = jQuery.ajax({
		type: "GET",
		cache: false,
		timeout: 300000,
		url: npk_site_url + "/wp-json/wp/v2/categories?per_page=100"
	})
	.done(function(){
		response = res.responseJSON;

		response.forEach(function(entry){
			//console.log(entry)
			if(npk_eventi && entry.slug == "eventi" ){
				elaborateData("eventi",entry.id);
			}

			if(npk_viabilita && entry.slug == "viabilita" ){
				elaborateData("viabilita",entry.id);
			}

			if(npk_sagre && (entry.slug == "sagre" || entry.slug == "sagre-napoli-campania") ){
				elaborateData("sagre",entry.id);
			}
		});
	})
	.fail(function() {
		console.log( "Errore temporaneo, contattare un amministratore." );
	})
	}
	catch(e){
		console.log(e);
	}
});

function elaborateData(name,id){
	if( name && id ){
		// Elaboro la richiesta
		var jqxhr = jQuery.ajax( {
			type : "GET", // definisco il tipo in POST
			//headers: { "Access-Control-Allow-Origin": "https://www.napolike.it" },
			data: JSON.stringify({
			}), 
			async: true,
			/*xhrFields: {
				withCredentials: true,
				origin: "https://www.napolike.it"
			},*/
			cache: false,
			timeout: 300000,
			error: function(xhr, resp, text){
				return true;
			},
			url: npk_site_url + "/wp-json/wp/v2/posts?categories=" + id
		} )
		.done(function() {
			inner_response = jqxhr.responseJSON;
			
			count = 0;
			
			inner_response.forEach(function(entry){
				if(count > npk_quanti){
					return false;
				}
				else{
					count++;
				}

				strong = jQuery("<strong>").html(entry.title.rendered);
				
				notice = jQuery("<div>",{
					class: "notice notice-sm"
				}).append(strong);
				
				a = jQuery("<a>",{
					target: "_blank",
					rel: "nofollow",
					href: entry.link
				}).append(notice);
				
				jQuery(".npk_" + name).find(".notice-spinner").remove();
				
				jQuery(".npk_" + name).append(a);
			});
		})
		.fail(function() {
			console.log( "Errore temporaneo, contattare un amministratore." );
		})
		.always(function() {
			jQuery(".notice-spinner").remove();
		});
	}
	
	return(false);
}