function calcPrice(obj, id, originalPrice, ajax=false)
{
	var qty = obj.value;

	var pHT = originalPrice;

	pHT = (pHT * qty);
	var pTTC =  pHT * 1.2;

	document.getElementById('PHT_'+id).innerHTML = String(pHT.toFixed(2)).replace('.', ',')+"€";
	document.getElementById('PTTC_'+id).innerHTML = String(pTTC.toFixed(2)).replace('.', ',')+"€";
}

function getProductsModal(title, img, content, price, id) {
	$('#modal-message').removeAttr('class').text('');

	$('#modal-title').text(title);
	$('#modal-body-img').attr('src', img).attr('alt', title);
	$('#modal-body').text(content);
	$('#modal-body-price').text(price+'€');
	$('#product_id').attr('onclick', 'addToCart('+id+')');


}

function getProductsModal(title, img, content, price, id) {
	$('#modal-message').removeAttr('class').text('');

	$('#modal-title').text(title);
	$('#modal-body-img').attr('src', img).attr('alt', title);
	$('#modal-body').text(content);
	$('#modal-body-price').text(price+'€');
	$('#product_id').attr('onclick', 'addToCart('+id+')');
}

function chooseAddress(id, user_id){	

	$('div.choix').on("click",function(){
		if(!$(this).hasClass("bg-secondary"))
		{
			$('div.choix').removeClass("bg-secondary");
			$(this).addClass("bg-secondary");
		}
		else
		{
			$('div.choix').removeClass("bg-secondary");
		}
	});
	// $.post('/choix', {id:id, user_id:user_id}, function(data){
		
	// 	if (data !== 'error') {
	// 		lines = JSON.parse(data);
	// 		for (const [key, item] of Object.entries(lines)) {
	// 			document.getElementById(key).value = item;
	// 		}
	// 	}else{
	// 		alert("Une erreur s'est produit!");
	// 	}
	// 	console.log(data);
	// })
	document.getElementById("adress"+id);
	
}

function addBasket(id) {
	
	var user_id = document.getElementsById('user_id'+id)[0].value;
	var beer_id = document.getElementsById('beer_id'+id)[0].value;
	var beerPriceHT = document.getElementsById('beer_priceHT'+id)[0].value;
	var beerQTY = document.getElementsById('qty'+id)[0].value;
	var token = document.getElementsById('token'+id)[0].value;
	
	$.post('/panier', {user_id:user_id, beer_id:beer_id, beerPriceHT:beerPriceHT, beerQTY : beerQTY, token:token}, function(data){
		if (data === "ok") {
			console.log("basketstyle");
			alert("Votre produit a bien été ajouté à votre panier");
		}else{
			alert('Erreur insertion panier');
		}
	})
}