$(document).ready(function() {
	$('#raffleaddbut').click(function (e) {

		$("<input class='span5' type='text' name='raffle[]' />").appendTo("#raffleadd");

	});
});