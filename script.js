const form = document.querySelector('form');
const results = document.querySelector('#results');

form.addEventListener('submit', (event) => {
	event.preventDefault();
	
	const keyword = form.keyword.value;
	const minNumber = form.minNumber.value;
	const maxNumber = form.maxNumber.value;
	
	fetch(`search.php?keyword=${keyword}&minNumber=${minNumber}&maxNumber=${maxNumber}`)
		.then(response => response.text())
		.then(data => results.innerHTML = data);
});

setInterval(() => {
	const keyword = form.keyword.value;
	const minNumber = form.minNumber.value;
	const maxNumber = form.maxNumber.value;
	
	fetch(`search.php?keyword=${keyword}&minNumber=${minNumber}&maxNumber=${maxNumber}`)
		.then(response => response.text())
		.then(data => {
			if (data !== results.innerHTML) {
				results.innerHTML = data;
			}
		});
}, 5000);
