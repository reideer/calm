
function QuestionWidget(questionId) {

	this.questionId = questionId;
	this.answers = new Array();
	this.description = '';
	this.owner = null;
	this.created = '';

	this.toHtmlText = function () {

		var html = '<li id="question' + this.questionId + '" class="streamQuestionsItem">' + '\r\n';
		html += '       <div class="questionDescription" id="questionDescription' + this.questionId + '">' + '\r\n';
		html += '               <div style="float:left; padding:5px;margin:2px;">' + '\r\n';
		html += '                       <div class="postInfo">' + '\r\n';
		html += '                               <div>' + this.owner.firstname + '</div>' + '\r\n';
		html += '                               <div><img src="https://lh4.googleusercontent.com/-t2SbMDyhvzk/AAAAAAAAAAI/AAAAAAAAARE/-u-gxAPcPOU/s46-c-k-no/photo.jpg" /></div>' + '\r\n';
		html += '                               <time datetime="' + this.created + '" class="timeago"></time>' + '\r\n';
		html += '                       </div>' + '\r\n';
		html += '                       </div>' + '\r\n';
		html += '                       <div>' + this.description + '</div>' + '\r\n';
		html += '               </div>' + '\r\n';
		html += '               <div id="question' + this.questionId + 'Details">' + '\r\n';
		html += '                       <div id="questionAnswers' + this.questionId + '">' + '\r\n';
		html += '               </div>' + '\r\n';
		html += '               <div id="formAnswers' + this.questionId + '"></div>' + '\r\n';
		html += '       </div>' + '\r\n';
		html += '</li>' + '\r\n';
		return html;

    }


    this.findAnswers = function(){

        var htmlAnswers = '<div id="answers' + this.questionId + '" class="answers"><ul class="listAnswers" id="listAnswers' + this.questionId  + '">';
        $.ajax({
            url: '../api/answers/' + this.questionId + '',
            dataType: "json",
            type: 'GET',
            context: this,
            success: function (json) {

                for (var i = 0; i < json.data.length; i++) {
                        var answer = new AnswerWidget(this.questionId);
                        answer.owner = json.data[i].user.firstname;
                        answer.description = json.data[i].answer;
                        answer.created = json.data[i].published;
                        htmlAnswers += answer.toHtmlText();
                }

            },
            complete: function () {
                htmlAnswers += '</ul></div>';
alert(this.questionId);
                $('#questionAnswers'+this.questionId).append(htmlAnswers);
                jQuery(".timeago").timeago();
            }
        });

    }


}

function AnswerWidget(questionId){

    this.questionId = questionId;
    this.owner = '';
    this.description = '';
    this.created = '';

    this.toHtmlText = function () {
        var html = '';
        html = '<li class="answer">' + '\r\n';
        html += '       <div class="postInfo">' + '\r\n';
        html += '               <div><img src="https://lh5.googleusercontent.com/-ZObtetjnKXM/AAAAAAAAAAI/AAAAAAAAVoI/KhkS5eT3WsY/s46-c-k-no/photo.jpg" /></div>\r\n';
        html += '               <div>' + this.owner + '</div>\r\n';
        html += '               <time class="timeago" datetime="' + this.created + '"></time>' + '\r\n';
        html += '       </div>' + '\r\n';
        html += this.description + '\r\n';
        html += '</li>' + '\r\n'
        return html;
    }

}


function Stream(){

	this.questions = new Array();

	this.init = function(){
		var idDiscipline = 1
		this.showQuestions(idDiscipline);
	}

	this.showQuestions = function(idDiscipline){
		$.ajax({
        		url: '../api/discipline/questions/'+ idDiscipline + '',
			dataType: "json",
        	    	type: 'GET',
           		context: this,
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
		    question = new QuestionWidget();
		    question.questionId = questionId;
		    question.findAnswers();
                    //var container = new AnswerContainer();
                    //container.questionId = questionId;
                    //container.showAnswers();

            	});
    	}


        this.addQuestion = function(jsonQuestion){
                var question = new QuestionWidget(jsonQuestion.id);
                question.created = jsonQuestion.published;
                question.description = jsonQuestion.question;
                question.owner = jsonQuestion.user;
                
                this.questions.push(question);
        }

	this.populateHtmlStream = function(){

		for (var i = 0; i < this.questions.length; i++) {
			$('#streamQuestions').append(this.questions[i].toHtmlText());
		}

        	this.onQuestionClick();

		jQuery(".timeago").timeago();

	}

}

            
$(document).ready(function () {

    var stream = new Stream();
    stream.init();

});
