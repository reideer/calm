function AnswerContainer(){
	this.questionId = null;
	this.answers = new Array();
	this.findAnswers = function(){
	
	//	var htmlFormAnswers = '<div class="formAnswer"> <form method="POST" id="formCreateAnswer' + this.questionId + '" action="/~calm/app_dev.php/create_answer/' + this.questionId + '">';
		var htmlAnswers = '<div id="answers' + this.questionId + '" class="answers"><ul class="listAnswers" id="listAnswers' + this.questionId  + '">';
		$.ajax({
			url: '../api/answers/' + this.questionId + '',
			dataType: "json",
			type: 'GET',
			context: jQuery("#questionAnswers" + this.questionId),
			success: function (json) {
			  
				for (var i = 0; i < json.data.length; i++) {
					var answer = new Answer(this.questionId);
					answer.owner = json.data[i].user.firstname;
					answer.description = json.data[i].answer;
					answer.created = json.data[i].published;
					htmlAnswers += answer.toHtmlText();
				}
				
			},
			complete: function () {
			    htmlAnswers += '</ul></div>';
			    this.append(htmlAnswers);
			    // waitingData = false;
			    jQuery(".timeago").timeago();
			}
		});
		
	}
	
	this.showFormAnswer = function () {
		var htmlFormAnswers = '<div class="formAnswer"> <form method="POST" id="formCreateAnswer' + this.questionId + '" action="/~calm/app_dev.php/create_answer/' + this.questionId + '">';
that = this;
		$.ajax({

			url: '../api/answer/' + this.questionId + '',

			type: 'GET',

			context: jQuery("#formAnswers" + this.questionId),

			success: function (json) {

				htmlFormAnswers += '<div class="formAnswerText">';
				htmlFormAnswers += '	<textarea class="answerDescription" placeholder="Contribua com a sua resposta" id="answer_description' + this.questionId + '" required="required" name="answer[description]"></textarea>';
				htmlFormAnswers += '</div>';
				htmlFormAnswers += '<input id="answer__token" type="hidden" value="' + json._token + '" name="answer[_token]">';
				htmlFormAnswers += '<input id="enviar" class="answerButton" type="button" value="Responder">';

			},

			complete: function () {

				htmlFormAnswers += '</form></div>';
				this.append(htmlFormAnswers);

				//waitingForm = false;

				//showAnswers(questionId);

				that.onAnswerSubmit();
			    
			}

		});

	}
	
	
	
	
	this.onAnswerSubmit = function(){
		$('#enviar').click(function () {
			var form = $('#enviar').closest("form").get(0);
			questionId = form.id.substring(16);

			$.ajax({
				url: "../create_answer/" + questionId,
				global: false,
				type: "POST",
				data: $("#formCreateAnswer" + questionId).serialize(),
				dataType: 'json',
				async: false,
				success: function (retorno) {

					if (retorno.status == 'fail') {
						alert(retorno.error.message);
						return;
					}
					var htmlAnswers = '';

					var answers = retorno.question.answers;

					for (var i = 0; i < retorno.question.answers.length; i++) {

						var answer = new Answer(questionId);

						answer.owner = retorno.question.answers[i].user.firstname;
						answer.description = retorno.question.answers[i].answer;
						answer.created = retorno.question.answers[i].published;
						htmlAnswers += answer.toHtmlText();

					}
					$('#answer_description' + questionId).val('');
					var lans = $('#listAnswers' + questionId).append(htmlAnswers);

				},
				complete: function () {
					jQuery(".timeago").timeago();
				}
			});

		});
	}
	
	this.showAnswers = function(){
		    this.showFormAnswer();
		    this.findAnswers();
	}
	
}


function Answer(questionId) {
    this.questionId = questionId;
    this.owner = '';
    this.description = '';
    this.created = '';

    this.toHtmlText = function () {
        var html = '';
        html = '<li class="answer">' + '\r\n';
        html += '	<div class="postInfo">' + '\r\n';
        html += '		<div><img src="https://lh5.googleusercontent.com/-ZObtetjnKXM/AAAAAAAAAAI/AAAAAAAAVoI/KhkS5eT3WsY/s46-c-k-no/photo.jpg" /></div>\r\n';
        html += '		<div>' + this.owner + '</div>\r\n';
        html += '		<time class="timeago" datetime="' + this.created + '"></time>' + '\r\n';
        html += '	</div>' + '\r\n';
        html += this.description + '\r\n';
        html += '</li>' + '\r\n'
        return html;
    }

}

function Question(questionId) {
    this.questionId = questionId;
    this.answers = new Array();
    this.description = '';
    this.owner = null;
    this.created = '';

    this.toHtmlText = function () {

        var html = '<li id="question' + this.questionId + '" class="streamQuestionsItem">' + '\r\n';
        html += '	<div class="questionDescription" id="questionDescription' + this.questionId + '">' + '\r\n';
        html += '		<div style="float:left; padding:5px;margin:2px;">' + '\r\n';
        html += '			<div class="postInfo">' + '\r\n';
        html += '				<div>' + this.owner.firstname + '</div>' + '\r\n';
        html += '				<div><img src="https://lh4.googleusercontent.com/-t2SbMDyhvzk/AAAAAAAAAAI/AAAAAAAAARE/-u-gxAPcPOU/s46-c-k-no/photo.jpg" /></div>' + '\r\n';
        html += '				<time datetime="' + this.created + '" class="timeago"></time>' + '\r\n';
        html += '			</div>' + '\r\n';
        html += '			</div>' + '\r\n';
        html += '			<div>' + this.description + '</div>' + '\r\n';
        html += '		</div>' + '\r\n';
        html += '		<div id="question' + this.questionId + 'Details">' + '\r\n';
        html += '			<div id="questionAnswers' + this.questionId + '">' + '\r\n';
        html += '		</div>' + '\r\n';
        html += '		<div id="formAnswers' + this.questionId + '"></div>' + '\r\n';
        html += '	</div>' + '\r\n';
        html += '</li>' + '\r\n';
        return html;
    }
    
}


function Stream() {
  
    this.init = function(){
	this.findQuestions(prompt("Digite o Codigo da disciplina? 'ainda precisa colocar o titulo da disciplina'"));
    }
    this.questions = [];

    this.addQuestion = function (jsonQuestion) {
        var question = new Question(jsonQuestion.id);
        question.created = jsonQuestion.published;
        question.description = jsonQuestion.question;
        question.owner = jsonQuestion.user;
        this.questions.push(question);
    }

    this.setQuestions = function (questionsArray) {
        this.questions = questionsArray;
    }
    
    this.closeQuestionContainer = function (questionId) {
	if (questionId != null) {
	    $('#questionAnswers' + questionId).get(0).innerHTML = '';
	    $('#formAnswers' + questionId).get(0).innerHTML = '';
	    $('#question' + questionId + 'Details').removeClass('questionDetailsActive');
	    $('#question' + questionId + '').removeClass('questionActive');
	}
    }
    
    this.onQuestionClick = function () {
	that = this;
	    $(".questionDescription").click(function () {
		    var questionId = this.id.substring(19);

		    if ($('#question' + questionId).hasClass('questionActive')) {
			    that.closeQuestionContainer(questionId);
			    return;
		    }
		    $('#question' + questionId + 'Details').addClass('questionDetailsActive');
		    $('#question' + questionId).addClass('questionActive');

		    var container = new AnswerContainer();
		    container.questionId = questionId;
		    container.showAnswers();

	    });
    }


    this.populateHtmlStream = function () {
        for (var i = 0; i < this.questions.length; i++) {
            $('#streamQuestions').append(this.questions[i].toHtmlText());	  		
	}
	this.onQuestionClick();
	jQuery(".timeago").timeago();

    }


    this.findQuestions = function (disciplineId) {
        $.ajax({
            url: '../api/discipline/questions/' + disciplineId + '',
            dataType: "json",
            type: 'GET',
            context: this,
            //context: jQuery("#questionAnswers"+questionId),
            success: function (json) {

		for (var i = 0; i < json.data.length; i++) {
                    this.addQuestion(json.data[i]);
                }
                
                this.populateHtmlStream();
				
            },
            complete: function () {

            }
        });
    }

}



var showAnswers = function (questionId) {
    var htmlAnswers = '<div id="answers' + questionId + '" class="answers"><ul class="listAnswers" id="listAnswers' + questionId + '">';

    $.ajax({
        url: '../api/answers/' + questionId + '',
        dataType: "json",
        type: 'GET',
        context: jQuery("#questionAnswers" + questionId),
        success: function (json) {

            for (var i = 0; i < json.data.length; i++) {

                var answer = new Answer(questionId);
                answer.owner = json.data[i].user.firstname;
                answer.description = json.data[i].answer;
                answer.created = json.data[i].published;
                htmlAnswers += answer.toHtmlText();

            }


        },
        complete: function () {
            htmlAnswers += '</ul></div>';
            this.append(htmlAnswers);
           // waitingData = false;
            jQuery(".timeago").timeago();
        }
    });

}

	


$(document).ready(function () {

    //jQuery(".timeago").timeago();

    var stream = new Stream();
    stream.init();


});