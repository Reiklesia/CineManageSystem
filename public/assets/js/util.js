let formChanged = false;

function setupUnsavedWarning() {
  const forms = document.querySelectorAll("form");

  forms.forEach((f) => {
    f.addEventListener("change", () => {
      formChanged = true;
    });

    f.addEventListener("submit", () => {
      formChanged = false;
    });
  });

  window.addEventListener("beforeunload", (event) => {
    if (!formChanged) return;
    event.preventDefault();
    event.returnValue = "Voulez-vous vraiment quitter sans enregistrer ?";
  });

  document.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", (event) => {
      if (!formChanged) return;
      if (!confirm("Voulez-vous vraiment quitter sans enregistrer ?")) {
        event.preventDefault();
      }
    });
  });
}

function setupPreviewAffiche() {
  const input = document.getElementById("inputAffiche");
  const img = document.getElementById("previewAffiche");
  if (!input || !img) return;

  let previousUrl = null;

  input.addEventListener("change", function () {
    const file = this.files && this.files[0] ? this.files[0] : null;
    if (!file) return;

    if (!file.type || !file.type.startsWith("image/")) {
      alert("Veuillez choisir un fichier image (png, jpg, webp).");
      input.value = "";
      return;
    }

    if (previousUrl) URL.revokeObjectURL(previousUrl);
    previousUrl = URL.createObjectURL(file);
    img.src = previousUrl;
  });
}

function setupFiltreForms() {
  const select = document.getElementById("selectFiltre");
  if (!select) return;

  const forms = document.querySelectorAll(".admin-form-filtre");
  if (!forms.length) return;

  const placeholders = {
    titre: "Filtrer par titre",
    realisateur: "Filtrer par réalisateur",
    annee: "Filtrer par année",
    statut: "Filtrer par statut",
    genre: "Filtrer par genre"
  };

  function showForm(val) {
    forms.forEach((f) => {
      const isActive = f.getAttribute("data-filtre") === val;
      f.style.display = isActive ? "" : "none";

      if (isActive) {
        const input = f.querySelector('input[type="text"], input[type="number"]');
        if (input && placeholders[val]) {
          input.placeholder = placeholders[val];
        }
      }
    });
  }

  showForm(select.value);
  select.addEventListener("change", () => showForm(select.value));
}

document.addEventListener("DOMContentLoaded", () => {
  setupUnsavedWarning();
  setupPreviewAffiche();
  setupFiltreForms();
});