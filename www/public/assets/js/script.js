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

	document.getElementById("adress"+id);
	
}

function addToBasket(id) {
	
	var beer_id = id;
	console.log('appel'+id);
	//créer un fichier provisoire pour envoyer post contenant les données de bière au panier

}