const elements = document.querySelectorAll('code');
const regex = /\$ *?/g;
elements.forEach(element => {
	if(regex.test(element.textContent)){
		element.classList.add('prefix');
		element.textContent = element.textContent.replace(regex, '');
	}
});

let titles = document.querySelectorAll('article h2');
titles.forEach(title => {
	const element = document.createElement('span');
	element.classList.add('hover-effect');
	element.textContent = '#';
	title.appendChild(element);
});