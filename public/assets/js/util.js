let formChanged = false;

const form = document.querySelector("form");
if (form) {
	form.addEventListener("change", () => {
		formChanged = true;
	});

	form.addEventListener("submit", () => {
		formChanged = false;
	});
}

window.addEventListener("beforeunload", (event) => {
	if (formChanged) {
		event.preventDefault();
		event.returnValue = "Voulez-vous vraiment quitter sans enregistrer ?";
	}
});

document.querySelectorAll("a").forEach((link) => {
	link.addEventListener("click", (event) => {
		if (formChanged && !confirm("Voulez-vous vraiment quitter sans enregistrer ?")) {
			event.preventDefault();
		}
	});
});
