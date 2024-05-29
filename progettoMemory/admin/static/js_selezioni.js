let scelte = [];

function cambiaSfondo(img) {
    if (window.getComputedStyle(img.parentNode).backgroundColor === 'rgb(197, 136, 191)') {
        img.parentNode.style.backgroundColor = 'rgb(255, 228, 225)';
    } else {
        img.parentNode.style.backgroundColor = 'rgb(197, 136, 191)';
    }
}

function salvaIndice(indiceImmagine) {
    if (scelte.includes(indiceImmagine)) {
        scelte.splice(scelte.indexOf(indiceImmagine), 1);
    } else {
        scelte.push(indiceImmagine);
    }
    console.log(scelte);
}


function conferma() {
	  
	if (scelte.length === 0) {
		// alert("Nessuna immagine selezionata");
		// return;
        scelte=["all"]
	}

	let stringaScelte = scelte.join(",");

	console.log(stringaScelte);

	window.location.href = "admin.php?scelte=" + stringaScelte;
}