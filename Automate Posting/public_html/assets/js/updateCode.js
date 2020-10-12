let titles = document.querySelectorAll('article h2');
titles.forEach(title => {
	const element = document.createElement('span');
	element.classList.add('hover-effect');
// 	element.innerHTML = '<i class="fas fa-link"></i>';
    element.textContent = "#";
	title.appendChild(element);
});
