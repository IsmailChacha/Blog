const views = {
	form : document.forms['input-form'],
	responseDiv : document.querySelector('#responses'),
	message : document.querySelector('.message'),
	number : document.querySelector('.number'),
	continue : document.querySelector('.continue'),
	cancel : document.querySelector('.cancel'),
	'final-response' : document.querySelector('#final-response'),

	hide(element)
	{
		element.style.display = 'none';
	},

	show()
	{
		element.style.display = 'block';
	},

	setup (elementsToHide = [], elementsToShow = [])
	{
		if(!empty(elementsToHide))
		{
			elementsToHide.forEach((element) => this.hide(element));
			elementsToshow.forEach((element) => this.show(element));
		}
	},

	displayContent(elementAndContent)
	{
		for(const group in elementAndContent)
		{
			for(const [element, content] in group)
			{
				element.innerHTML = content;
			}
		}
	}
};

//request data from server
let xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = () => {
	alert(xmlhttp.readyState);
	console.log(xmlhttp.status);

	if(xmlhttp.readyState  == 4 && xmlhttp.status == 200)
	{
		// let response = JSON.parse(xmlhttp.responseText);
		console.log(xmlhttp.responseText);

		// display the responses
		// views.displayContent([[`views.message`, `response.message`], [`views.number`, `response.number`]]);
		// setup the view
		views.setup([views.form], [views.responseDiv]);
	} else 
	{
		console.log('Something is amess!');
	}
};

xmlhttp.open('POST', 'index.php', true);
request.setRequestHeader("Content-type", "application/json");
xmlhttp.send();

// attach events to the continue/cancel buttons
let buttonsArray = [];
buttonsArray.push(views.continue, views.cancel);
buttonsArray.forEach((button) => {
	button.addEventListener('click', (event) => {
		// setup the display again
		// hide response div and display the form
		views.setup([views.responseDiv], [views.form]);

		let value = event.target.value;
		if(value == 'continue')
		{
			// code if user wants to proceed
			// signal server to proceed
			const opResponse = {action : "proceed"};

		} elseif(value == 'cancel') 
		{
			// code to cancel
			// signal server to abort
			const opResponse = {action : "cancel"};

			// Receive final response from server
			let finalResponse = new XMLHttpRequest();
			finalResponse.onreadystatechange() = () => {
				if(this.readyState == 4 && this.status == 200)
				{
					// let response = JSON.parse(this.responseText);
					//then display it to the user
					// display the responses
					views.displayContent([[`views.final-response`, `response.status`]]);
				}
			};
		}

		const opResponseObj = JSON.stringify(opResponse); //create the response JSON string
		// create request
		const request = new XMLHttpRequest();
		request.open("POST", "index.php", true);
		request.setRequestHeader("Content-type", "application/json");
		request.send(opResponseObj);
	});
});
