'use strict'

//accueil.phtml
//slideA
function slideA()
{
	var active = $('#slideA .active');
	var next = (active.next().length >0) ? active.next() : $('#slideA img:first');

	active.fadeOut(function()
	{
		active.removeClass('active');
		next.fadeIn().addClass('active');
	});	
}
setInterval('slideA()',5000);

//slideB
function slideB()
{
	var active = $('#slideB .active');
	var next = (active.next().length >0) ? active.next() : $('#slideB img:first') ;
	active.fadeOut(function()
	{
		active.removeClass('active');
		next.fadeIn().addClass('active');
	});
}
setInterval('slideB()', 5000);

//inscription.phtml
const divcontener= $("#divContainerInscription");

const links= $("a.lightbox");

let aHref = links.attr("href");

let img = $("#divContainerInscription img");

let linksImg = img.attr("src");


links.click(function oneClick(event)
{
	event.preventDefault();
	divcontener.fadeIn(1000);
	let href = this.getAttribute("href");// let href = this.href;
	img.attr("src",href);
});

divcontener.click(function out()
{	
	divcontener.fadeOut(1000)				
});


//rdv.phtml
jQuery(function($)
{
	$('.month').hide();
	$('.month:first').show();
	$('.months option:first').addClass('active');

	var current =1;

	$('.month_option option').click(function()
	{
		var month = $(this).attr('id').replace('linkMonth','');
		if(month != current)
		{
			$('#month'+current).slideUp();
			$('#month'+month).slideDown();
			$('.month_option option').removeClass('active');
			$('.month_option option#linkMonth'+month).addClass('active');
			current = month;			
		}
	});

		/*$('#submitRdv').click(function()
		{	
			$('#rdv').replaceWith("<div style='text-align:center ; font-size: 1.5em;'>Votre rendez-vous a bien été enregistré. Un mail de confirmation vous a été envoyé<div>");
		});*/
	
});