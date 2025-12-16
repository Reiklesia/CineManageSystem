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

function previewAffiche() {
  const input = document.getElementById('inputAffiche');
  const img = document.getElementById('previewAffiche');
  if (!input || !img) return;

  let previousUrl = null;

  input.addEventListener('change', function () {
    const file = this.files && this.files[0] ? this.files[0] : null;
    if (!file) return;

    if (!file.type || !file.type.startsWith('image/')) {
      alert("Veuillez choisir un fichier image (png, jpg, webp).");
      input.value = "";
      return;
    }

    if (previousUrl) URL.revokeObjectURL(previousUrl);
    previousUrl = URL.createObjectURL(file);
    img.src = previousUrl;
  });
}

document.addEventListener("DOMContentLoaded", () => {
  previewAffiche();
});