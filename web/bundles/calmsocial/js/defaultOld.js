
var closeElement = function (questionId){
		if(questionId != null){
			$('#questionAnswers'+ questionId).get(0).innerHTML = '';
			$('#formAnswers'+ questionId).get(0).innerHTML = '';
			$('#question'+questionId+'Details').removeClass('questionDetailsActive');
			$('#question'+questionId+'').removeClass('questionActive');
		}
}
/*
$(document).ready(function(){
	jQuery(".timeago").timeago();
//	var elementClicked = lastElementClicked = null;
	var waitingForm = waitingData = false;
	
	
	//$(".streamQuestionsItem").click(function(){
	$(".questionDescription").click(function(){

		var questionId = this.id.substring(19);
		
		if ($('#question'+questionId).hasClass('questionActive')){
			closeElement(questionId);
			return;
		};


var closeElement = function (element){
		if(element != null){
			$('#questionAnswers'+ element.id.substring(8)).get(0).innerHTML = '';
			$('#formAnswers'+ element.id.substring(8)).get(0).innerHTML = '';
			$('#question'+element.id.substring(8)+'Details').removeClass('questionDetailsActive');
			$('#question'+element.id.substring(8)+'').removeClass('questionActive');
		}
}
*/
$(document).ready(function(){
	jQuery(".timeago").timeago();
//	var elementClicked = lastElementClicked = null;

	
	$(".questionDescription").click(function(){
		var questionId = this.id.substring(19);
		alert(questionId);
		
		if ($('#question'+questionId).hasClass('questionActive')){
			closeElement(this)
			return;
		};
	
		if( waitingForm == true || waitingData == true) return;
					  
		waitingForm = waitingData = true;		
		
		//elementClicked = this;
//		closeElement(lastElementClicked);
//		lastElementClicked = elementClicked;

        

		$('#question'+questionId+'Details').addClass('questionDetailsActive');
		$('#question'+questionId).addClass('questionActive');
		
		showFormAnswer(questionId);
		
		

	});
	
		var waitingForm = waitingData = false;
/*	$(".questionDescription").click(function(){
		closeElement(this.id.substring(19));
	});*/
	var showAnswers = function(questionId){	
	
		var htmlAnswers = '<div id="answers'+questionId+'" class="answers"><ul class="listAnswers" id="listAnswers'+questionId+'">';
		
		$.ajax({
			url: 'api/answers/' + questionId + '',
			dataType: "json",
			type: 'GET',
			context: jQuery("#questionAnswers"+questionId),
			success: function(json){
			
				for (i = 0; i < json.data.length; i++){
					htmlAnswers += '<li  class="answer">'+ 
								json.data[i].user.firstname + ' : <time class="timeago" datetime="'+json.data[i].published + '"></time> : ' +
								json.data[i].answer
							+ '</li>';
					
				}
				
			
			},
			complete: function(){
				htmlAnswers += '</ul></div>';
				this.append(htmlAnswers);
				waitingData = false;
				jQuery(".timeago").timeago();
			}
		}); 
		
	}
	
	var showFormAnswer = function(questionId){
	
		var htmlFormAnswers = '<div class="formAnswer"> <form method="POST" id="formCreateAnswer'+questionId+'" action="create_answer/'+questionId+'">';
		
		$.ajax({
		
		    url: 'api/answer/' + questionId + '',
			
		    type: 'GET',
			
		    context: jQuery("#formAnswers"+questionId),
			
		    success: function(json){
			
				htmlFormAnswers +='<div class="formAnswerText">';
				htmlFormAnswers +='	<textarea class="answerDescription" placeholder="Contribua com a sua resposta" id="answer_description'+questionId+'" required="required" name="answer[description]"></textarea>';
				htmlFormAnswers +='</div>';
				htmlFormAnswers +='<input id="answer__token" type="hidden" value="'+json._token+'" name="answer[_token]">';
				htmlFormAnswers +='<input id="enviar" class="submitAnswer" type="button" value="Responder">';
			
		    },
			
		    complete: function(){
			
				htmlFormAnswers += '</form></div>';				
				this.append(htmlFormAnswers);
				
	            waitingForm = false;
				
				showAnswers(questionId);
				
				$('#enviar').click(function(){
					var form = $('#enviar').closest("form").get(0);
					questionId = form.id.substring(16);
					waitingData = true;
					$.ajax({
						url: "create_answer/"+questionId,
						global: false,
						type: "POST",
						data: $("#formCreateAnswer"+questionId).serialize(),
						dataType: 'json',
						async:false,
						success: function(retorno){
							
							if(retorno.status == 'fail'){
								alert(retorno.error.message);
								return;
							}
							htmlAnswers = '';
							
							answers = retorno.question.answers;
							
							for (i = 0; i < retorno.question.answers.length; i++){
								htmlAnswers += '<li  class="answer">'+ 
											retorno.question.answers[i].user.firstname + ' : <time class="timeago" datetime="'+retorno.question.answers[i].published + '"></time> : ' +
											retorno.question.answers[i].answer
										+ '</li>';
								
							}
							$('#answer_description'+questionId).val('');
							var lans = $('#listAnswers'+questionId).append(htmlAnswers);
							
							//$('#questionAnswers'+retorno.question.id).children('#answers').children('#listAnswers').append(htmlAnswers);
						},
						complete: function(){
							waitingData = false;
							jQuery(".timeago").timeago();
						}
					});

				}); 
		    }
			
		}); 
	
	}
	

});