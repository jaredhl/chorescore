//fake database values
var pseudoChoreDatabase = ["Dishes","Vacuuming","Trash","Sweeping","Recycling","jerkin' it"];
var pseudoRoommateDatabase = [["Matt",50],["Adam",15],["Jared",-8]];
var pseudoRoommateChoreDatabase = [["Matt",0],["Matt",0],["Matt",2],["Matt",4],["Adam",1],["Adam",3],["Matt",4],["Jared",5],["Adam",2],["Matt",0]];


var choreCard = function(name,baseValue,refresh,lastCompleted){
	this.name = name;
	this.baseValue = parseInt(baseValue);
	this.refresh = parseInt(refresh);
	this.lastCompleted = parseInt(lastCompleted);
	this.urgency = this.lastCompleted - this.refresh;
	this.finalValue = 0;
	if (this.urgency < 0){
		this.finalValue = this.baseValue * -1 / (this.urgency-1);
	}
	else if (this.urgency == 0){
		this.finalValue = this.baseValue;
	}
	else{
		this.finalValue = this.baseValue * (this.urgency+1) / this.refresh;
	}
	this.finalValue = parseInt(this.finalValue);
	this.expanded = false;
	this.selected = false;
	var self = this;
	var htmlstring = "<div class = 'ccard'><text>" + String(name) + ": " +String(this.finalValue) +"</text></div>";
	this.html = $(htmlstring);
	
	
	if (this.urgency < 0){
		this.html.addClass("premature");
	}
	else if (this.urgency == 0){
		this.html.addClass("due");
	}
	else{
		this.html.addClass("overdue");
	}
	
	
	var hiddenhtmlstring = "<div class = 'extended'>Days since last completion: ";
	hiddenhtmlstring += String(this.lastCompleted) + "<br>Days desired between completions: " + String(this.refresh);
	hiddenhtmlstring += "</div>";
	this.hiddenhtml = $(hiddenhtmlstring);
	this.hiddenhtml.hide();
	this.html.append(this.hiddenhtml);
	//when clicked a roomie card will display expanded html
	this.html.on('click',function(){ 
		if (completingChore){
			var select = !self.selected;
			self.html.toggleClass("selected");
			
			if (select){
				for (var i = 0; i < choreCards.length; i++){
					choreCards[i].selected = false;
				}
				self.selected = select;
			}
			
			
			//check for match
			for (i = 0; i < roomieCards.length; i++){
				if (roomieCards[i].selected){
					completeChore(roomieCards[i].name,self.name);
				}
			}
			
		}
		else{
			if (deletingChore){
				deleteChore(self.name); 
				deletingChore = false;
			}
			if (self.expanded) {
				self.hiddenhtml.hide();
				self.expanded = false;
			}
			else{
				self.hiddenhtml.show();
				self.expanded = true;
			}
		}
	});
	
};

function extractChoreData(){
	var result = []
	var fakeNumberOfChores = pseudoChoreDatabase.length;
	for (var i = 0; i < fakeNumberOfChores; i++){
		var chore = pseudoChoreDatabase[i];
		var lastCompleted = parseInt(Math.random() * 3);
		result.push(new choreCard(chore,5,1,lastCompleted));
	}
	return result;
}

function updateChoreDisplay(){
	//remove current roommate display
	var container = $("#chore_list");
	
	container.empty();
	
	
	//add current roomie cards to display
	for (var i = 0; i < choreCards.length; i+=1){
		container.append(choreCards[i].html);
	}
	
	
}

//removes roommate from global list based on name and score
function deleteChore(name){
	for (var i = 0; i < choreCards.length; i++){
		if (choreCards[i].name == name){
			choreCards.splice(i,1);
			break;
		}
	}
	
	//repopulating list, necessary for click handlers to function properly
	for (i = 0; i < choreCards.length; i++){
		var cur = choreCards[i];
		var temp = new choreCard(cur.name,cur.baseValue,cur.refresh,cur.lastCompleted);
		choreCards[i] = temp;
	}
	
	updateChoreDisplay();
}

//roomieCard stores data for each roommate, displayed as a 'card'
var roomieCard = function(name,score,choresCompleted){
	this.name = name;
	this.score = score;
	this.choresCompleted = [];
	this.expanded = false;
	this.selected = false;
	var self = this;
	
	//decode chore codes (store chore names)
	for (var i = 0; i < choresCompleted.length; i+=1){
		this.choresCompleted.push(choresCompleted[i]); //choresCompleted is list of chore names
	}
	
	//generate html display
	var htmlstring = "<div class = 'rcard'><text>" + String(name) + ": " + String(score) + "</text></div>";
	this.html = $(htmlstring);
	
	//when clicked a roomie card will display expanded html
	this.html.on('click',function(){ 
		if (completingChore){
			var select = !self.selected;
			self.html.toggleClass("selected");
			
			if (select){
				for (var i = 0; i < roomieCards.length; i++){
					roomieCards[i].selected = false;
				}
				self.selected = select;
			}
			
			
			//check for match
			for (var i = 0; i < choreCards.length; i++){
				if (choreCards[i].selected){
					completeChore(self.name, choreCards[i].name);
				}
			}
			

		}
		
		else{
			if (deletingRoomie){
				deleteRoommate(self.name,self.score);
				deletingRoomie = false;
			}
			if (self.expanded) {
				self.hiddenhtml.hide();
				self.expanded = false;
			}
			else{
				self.hiddenhtml.show();
				self.expanded = true;
			}
		
		}
	});
	
	//generate expanded html display
	var hiddenhtmlstring = "<div class = 'extended'>Recently completed chores: ";
	for (i = 0; i < this.choresCompleted.length; i+=1){
		hiddenhtmlstring += String(this.choresCompleted[i]);
		if (this.choresCompleted.length - i > 1) hiddenhtmlstring += ", ";
	}
	hiddenhtmlstring += "</div>";
	this.hiddenhtml = $(hiddenhtmlstring);
	
	
	this.hiddenhtml.hide();
	this.html.append(this.hiddenhtml);
};

function extractRoommateData(){
	var result = [];
	//***
	//make database request for roommates
	//***
	
	//real for loop should depend on number of records in database
	var fakeNumberOfRecords = pseudoRoommateDatabase.length;
	
	for (var i = 0; i < fakeNumberOfRecords; i+=1){
		var name = pseudoRoommateDatabase[i][0];
		var score = pseudoRoommateDatabase[i][1];
		var choreNames = [];

		//***
		//make database request for RoommateChores
		//***
		
		//real loop would depend on database response
		for (var j = 0; j < pseudoRoommateChoreDatabase.length; j+=1){
			if (pseudoRoommateChoreDatabase[j][0] == name) choreNames.push(pseudoChoreDatabase[pseudoRoommateChoreDatabase[j][1]]);
		}
		result.push(new roomieCard(name,score,choreNames));
		
	}
	
	return result;
}

//simple bubblesort for roomates based on current score
function sortRoommates(){
	for (var i = 0; i < roomieCards.length-1; i+=1){
		for (var j = i + 1; j < roomieCards.length; j+=1){
			if (roomieCards[i].score < roomieCards[j].score){
				var temp = roomieCards[i];
				roomieCards[i] = roomieCards[j];
				roomieCards[j] = temp;
			}
		}
	}
}


//removes roommate from global list based on name and score
function deleteRoommate(name, score){
	for (var i = 0; i < roomieCards.length; i++){
		if (roomieCards[i].name == name && roomieCards[i].score == score){
			roomieCards.splice(i,1);
			break;
		}
	}
	
	//repopulating list, necessary for click handlers to function properly
	for (i = 0; i < roomieCards.length; i++){
		var cur = roomieCards[i];
		var temp = new roomieCard(cur.name,cur.score,cur.choresCompleted);
		roomieCards[i] = temp;
	}
	
	sortRoommates();
	updateRoommateDisplay();
}

function updateRoommateDisplay(){
	//remove current roommate display
	var container = $("#roomie_list");
	
	container.empty();
	
	
	//add current roomie cards to display
	for (var i = 0; i < roomieCards.length; i+=1){
		container.append(roomieCards[i].html);
	}
}

function completeChore(roomieName,choreName){
	
	var i;
	var c;
	var r;
	var ci;
	var ri;
	for (i = 0; i < roomieCards.length; i++){
		if (roomieCards[i].name == roomieName){
			r = roomieCards[i];
			ri = i;
			break;
		}
	}
	for (j = 0; j < choreCards.length; j++){
		if (choreCards[j].name == choreName){
			c = choreCards[j];
			ci = j;
			break;
		}
	}
	r.choresCompleted.push(c.name);
	r.score = parseInt(r.score) + parseInt(c.finalValue);
	//roomieCards[ri] = new roomieCard(r.name,r.score,r.choresCompleted)
	
	c.lastCompleted = 0;
	//choreCards[ci] = new choreCard(c.name,c.baseValue,c.refresh,c.lastCompleted);
	resetCards();
	
	updateChoreDisplay();
	sortRoommates();
	updateRoommateDisplay();
	
	
}

function resetCards(){
	var i;
	var temp;
	deletingChore = false;
	deletingRoomie = false;
	completingChore = false;
	for (i = 0; i < roomieCards.length; i++){
		temp = roomieCards[i];
		roomieCards[i] = new roomieCard(temp.name,temp.score,temp.choresCompleted);
	}
	for (i = 0; i < choreCards.length; i++){
		temp = choreCards[i];
		choreCards[i] = new choreCard(temp.name,temp.baseValue,temp.refresh,temp.lastCompleted);
	}
}


var deletingChore = false;
var deletingRoomie = false;
var completingChore = false;
var roomieCards = [];
var choreCards = [];
//main
$(document).ready(function(){
	//alert("hi");


	var addingRoomie = false;
	var addingChore = false;

	//unpack roommate data
	roomieCards = extractRoommateData();
	var body = $("body");
	choreCards = extractChoreData();

	//add buttons to primary toolbar
	var primaryTools = $("<div id = 'primarytools'></div>");
	var addRoomieButton = $("<button>Add new roommate</button>");
	addRoomieButton.on('click',function(e){
		if (addingRoomie){
			newRoomieForm.hide();
		}
		else{
			newRoomieForm.show();
		}
		addingRoomie = !addingRoomie;
	});
	var newRoomieForm = $("<div id = 'new_roomie'></div>");
	newRoomieForm.append("<input id = 'new_roomie_name' type = 'text' value = 'Name'></input>");
	var newRoomieSubmit = $("<button id = 'roomie_submit'>submit</button>");
	newRoomieSubmit.on('click',function(e){
		roomieCards.push(new roomieCard($("#new_roomie_name").val(),0,[]));
		//repopulating list, necessary for click handlers to function properly
		for (i = 0; i < roomieCards.length; i++){
			var cur = roomieCards[i];
			var temp = new roomieCard(cur.name,cur.score,cur.choresCompleted);
			roomieCards[i] = temp;
		}
		sortRoommates();
		updateRoommateDisplay();
		var form = $("#new_roomie");
		form.hide();
		addingRoomie = false;
	});
	newRoomieForm.append(newRoomieSubmit);
	primaryTools.append(addRoomieButton);
	primaryTools.append(newRoomieForm);
	newRoomieForm.hide();
	
	
	
	var addChoreButton = $("<button>Add new chore</button>");
	addChoreButton.on('click',function(e){
		if (addingChore){
			newChoreForm.hide();
		}
		else{
			newChoreForm.show();
		}
		addingChore = !addingChore;
	});
	var newChoreForm = $("<div id = 'new_chore'></div>");
	newChoreForm.append("<input id = 'new_chore_name' type = 'text' value = 'Name'></input>");
	newChoreForm.append("<input id = 'new_chore_val' type = 'text' value = 'Base value'></input>");
	newChoreForm.append("<input id = 'new_chore_refresh' type = 'text' value = 'Refresh days'></input>");
	newChoreForm.append("<input id = 'new_chore_last' type = 'text' value = 'Days since completed'></input>");
	var newChoreSubmit = $("<button id = 'chore_submit'>submit</button>");
	newChoreSubmit.on('click',function(e){
		choreCards.push(new choreCard($("#new_chore_name").val(),$("#new_chore_val").val(),$("#new_chore_refresh").val(),$("#new_chore_last").val()));
		//repopulating list, necessary for click handlers to function properly
		for (i = 0; i < choreCards.length; i++){
			var cur = choreCards[i];
			var temp = new choreCard(cur.name,cur.baseValue,cur.refresh,cur.lastCompleted);
			choreCards[i] = temp;
		}
	
		updateChoreDisplay();
		var form = $("#new_chore");
		form.hide();
		addingChore = false;
		
	});
	newChoreForm.append(newChoreSubmit);
	primaryTools.append(addChoreButton);
	primaryTools.append(newChoreForm);
	newChoreForm.hide();
	
	var removeRoomieButton = $("<button>Remove roommate</button>");
	removeRoomieButton.on('click',function(e){
	
		deletingRoomie = !deletingRoomie;
		for (var i = 0; i < roomieCards.length; i++){
			roomieCards[i].html.toggleClass('highlighted');
		}
	});
	primaryTools.append(removeRoomieButton);
	
	
	var removeChoreButton = $("<button>Remove chore</button>");
	removeChoreButton.on('click',function(e){
		
		deletingChore= !deletingChore;
		for (var i = 0; i < choreCards.length; i++){
			choreCards[i].html.toggleClass('highlighted');
		}
	});
	primaryTools.append(removeChoreButton);
	
	//completing chore
	var completeChoreButton = $("<button>Chore finished</button>");
	completeChoreButton.on('click',function(e){
		
		completingChore = !completingChore;
		for (var i = 0; i < choreCards.length; i++){
			choreCards[i].html.toggleClass("highlighted");
		}
		for (var i = 0; i < roomieCards.length; i++){
			roomieCards[i].html.toggleClass("highlighted");
		}
	});
	primaryTools.append(completeChoreButton);
	
	
	
	
	//done with primary toolbar
	body.append(primaryTools);

	//add chorecards and roomiecards to display
	var choreDisplay = $("<div id = 'chore_list'></div>");
	body.append(choreDisplay);
	updateChoreDisplay();
	

	var roomieDisplay = $("<div id = 'roomie_list'></div>");
	body.append(roomieDisplay);
	sortRoommates();
	updateRoommateDisplay();
	
	
	
	//alert("after display");
	
	//add button(s) to secondary toolbar
	var secondaryTools = $("<div id = 'secondarytools'></div>");
	
	var leaderboardButton = $("<button>View previous leaderboards</button>");
	leaderboardButton.on('click',function(e){
		//***
		//display leaderboards
		//***
	});
	
	secondaryTools.append(leaderboardButton);
	secondaryTools.append("<br>");
	
	$("body").append(secondaryTools);
	//alert("end");
	
});
