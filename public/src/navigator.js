document.addEventListener("DOMContentLoaded", () => {
    let links = document.querySelectorAll("[data-page]");
    let main = document.getElementById("main-content");

    // Map des fonctions d'initialisation par page
    const pageInits = {
        'declaration': { script: 'src/declaration.js', init: 'initDeclarationPage' },
        // Ajoute ici les autres pages si besoin :
        // 'utilisateur': { script: 'src/utilisateur.js', init: 'initUtilisateurPage' },
    };

    /**
     * Charger un script dynamiquement (ne le recharge pas s'il est déjà présent)
     */
    function loadScript(src) {
        return new Promise((resolve) => {
            if (document.querySelector(`script[src="${src}"]`)) {
                resolve(); // déjà chargé
                return;
            }
            const s = document.createElement('script');
            s.src = src;
            s.onload = resolve;
            s.onerror = () => {
                console.error(`Impossible de charger le script : ${src}`);
                resolve(); // on resolve quand même pour ne pas bloquer
            };
            document.body.appendChild(s);
        });
    }

    /**
     * Charger une page et initialiser son script
     */
    async function loadPage(page) {
        try {
            const res = await fetch('pages/' + page + '.php');
            if (!res.ok) throw new Error(`Erreur HTTP ${res.status}`);

            const html = await res.text();
            main.innerHTML = html;

            // Si cette page a un script associé, le charger et appeler son init
            if (pageInits[page]) {
                const { script, init } = pageInits[page];
                await loadScript(script);

                if (typeof window[init] === 'function') {
                    window[init]();
                } else {
                    console.warn(`Fonction d'init introuvable : ${init}`);
                }
            }
        } catch (error) {
            console.error('Erreur lors du chargement de la page :', error);
            main.innerHTML = `<p style="color:red; padding:20px;">Impossible de charger la page.</p>`;
        }
    }

    links.forEach(link => {
        link.addEventListener("click", () => {
            const page = link.dataset.page;

            // Mettre à jour l'état actif
            links.forEach(l => l.classList.remove('active'));
            link.classList.add('active');

            loadPage(page);
        });
    });
});